<?php

namespace App\Http\Livewire;

use App\Http\Controllers\HomeController;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $filterDate;
    public $perPage = 10;
    public $editedOrder;

    public $statusList = array(
        0 => 'Новый заказ',
        1 => 'Нет в наличии',
    );

    protected $rules = [
        'filterDate' => 'required|before_or_equal:today',
    ];

    protected $messages = [
        'filterDate.required' => 'Выберите дату синхронизации.',
        'filterDate.before_or_equal' => 'Дата не может быть больше сегодняшней даты',
    ];

    public function paginationView()
    {
        return 'vendor.livewire.pagination';
    }

    public function mount()
    {
        $this->filterDate = null;
    }

    public function render()
    {
        $this->orders = Order::orderBy('creation_date', 'desc')->paginate($this->perPage);

        return view('livewire.orders', [
            'orders' => $this->orders,
        ]);
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function getRequestResult($url = null)
    {
        if ($url === null)
            return null;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array(
            "Content-Type: application/vnd.api+json",
            "X-Auth-Token: qXijdzwqsupucCJTZ9Gl/Tfma0LtAyRXI9JpsnI8QBU="
        );

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($curl);
        curl_close($curl);
        
        $result=json_decode($result,true);
        return $result;
    }

    public function api($startDay, $endDay)
    {
        // $today = intval(Carbon::yesterday()->startOfDay()->valueOf());
        $ordersResponse = $this->getRequestResult('https://kaspi.kz/shop/api/v2/orders?page[number]=0&page[size]=1000&filter[orders][state]=KASPI_DELIVERY&filter[orders][creationDate][$ge]=' . $startDay . '&filter[orders][creationDate][$le]=' . $endDay);
        $orders = $ordersResponse['data'];

        foreach ($orders as $index => $order) {
            $orderEntriesResponse = $this->getRequestResult('https://kaspi.kz/shop/api/v2/orders/' . $order['id'] . '/entries');
            $orderEntries = $orderEntriesResponse['data'];
            
            $orderMerchantProducts = array();
            foreach ($orderEntries as $orderEntry) {
                $orderEntryResponse = $this->getRequestResult($orderEntry['links']['self']);
                $entryProductResponse = $this->getRequestResult($orderEntryResponse['data']['relationships']['product']['links']['related']);
                $entryMerchantProductResponse = $this->getRequestResult($entryProductResponse['data']['relationships']['merchantProduct']['links']['related']);
                array_push($orderMerchantProducts, $entryMerchantProductResponse['data']['attributes']['code']);
            }

            $orders[$index]['products'] = $orderMerchantProducts;
        }

        return $orders;
    }

    public function sync()
    {
        $this->validate();
        
        $startDay = Carbon::createFromDate($this->filterDate);
        $endDay = $startDay->copy()->endOfDay();
        $startDay = intval($startDay->valueOf());
        $endDay = intval($endDay->valueOf());

        $orders = null;

        try {
            $orders = $this->api($startDay, $endDay);
        } catch (\Throwable $th) {
            session()->flash('notify', array('status' => 'danger', 'message' => 'Не удалось загружать список заказов.'));
        }

        if ($orders) {
            foreach ($orders as $order) {
                $existingOrder = Order::where('code', $order['attributes']['code'])->first();

                if ($existingOrder) {
                    $existingOrder->total_price = $order['attributes']['totalPrice']; 
                    $existingOrder->payment_mode = $order['attributes']['paymentMode']; 
                    $existingOrder->planned_delivery_date = Carbon::createFromTimestampMs($order['attributes']['plannedDeliveryDate'])->format('Y-m-d H:i:s');  
                    $existingOrder->creation_date = Carbon::createFromTimestampMs($order['attributes']['creationDate'])->format('Y-m-d H:i:s'); 
                    $existingOrder->delivery_mode = $order['attributes']['deliveryMode']; 
                    $existingOrder->state = $order['attributes']['state']; 
                    $existingOrder->status = $order['attributes']['status']; 
                    $existingOrder->delivery_cost = $order['attributes']['deliveryCost']; 
                    $existingOrder->save();

                    if ($order['products'] != null) {
                        $existingOrder->products()->detach();
                        foreach ($order['products'] as $sku) {
                            $product = Product::where('sku', $sku)->first();
                            if ($product) {
                                $existingOrder->products()->attach($product);
                            }
                        }
                    }
                } else {
                    $newOrder = new Order;
                    $newOrder->code = $order['attributes']['code'];
                    $newOrder->total_price = $order['attributes']['totalPrice']; 
                    $newOrder->payment_mode = $order['attributes']['paymentMode']; 
                    $newOrder->planned_delivery_date = Carbon::createFromTimestampMs($order['attributes']['plannedDeliveryDate'])->format('Y-m-d H:i:s'); 
                    $newOrder->creation_date = Carbon::createFromTimestampMs($order['attributes']['creationDate'])->format('Y-m-d H:i:s'); 
                    $newOrder->delivery_mode = $order['attributes']['deliveryMode']; 
                    $newOrder->state = $order['attributes']['state']; 
                    $newOrder->status = $order['attributes']['status']; 
                    $newOrder->delivery_cost = $order['attributes']['deliveryCost']; 
                    $newOrder->save();

                    if ($order['products'] != null) {
                        foreach ($order['products'] as $sku) {
                            $product = Product::where('sku', $sku)->first();
                            if ($product) {
                                $newOrder->products()->attach($product);
                            }
                        }
                    }
                }
            }

            session()->flash('notify', array('status' => 'success', 'message' => 'Список заказов успешно обновлен!'));
        } else {
            session()->flash('notify', array('status' => 'danger', 'message' => 'Список заказов на данную дату пуст!'));
        }

        $this->filterDate = null;
    }

    public function updateOrderStatus($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            session()->flash('notify', array('status' => 'danger', 'message' => 'Произошла ошибка!'));
            return false;
        }
        $order->warehouse_status = $this->editedOrder;
        $order->save();
        $this->editedOrder = null;
    }
}
