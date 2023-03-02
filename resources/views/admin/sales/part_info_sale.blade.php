<h2>Compra #{{ $purchase->id }}</h2>
<div class="row">
    <div class="col">
        <dl class="row">                    
            <dt class="col-sm-3"> Status</dt>
            <dd class="col-sm-9">{{ $sale_status }}</dd>
            
            <dt class="col-sm-3"> Payment Method</dt>
            <dd class="col-sm-9">{{ $purchase->payment_method }}</dd> 

            <dt class="col-sm-3"> Tracking</dt>
            <dd class="col-sm-9">{{ $purchase->tracking_number }}</dd>

            <dt class="col-sm-3"> Created</dt>
            <dd class="col-sm-9">{{ $purchase->created_at }}</dd>

            <dt class="col-sm-3"> Observations</dt>
            <dd class="col-sm-9">{{ $purchase->observations }}</dd>
        </dl>
        <hr>
    </div>
</div>