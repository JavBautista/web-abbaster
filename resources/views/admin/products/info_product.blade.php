<div class="row">        
        <div class="col col-md-6">    
            <dl class="row">              
              <dt class="col-sm-3">Proveedor</dt>
              <dd class="col-sm-9">{{ $product->proveedor->name }}</dd>
              <dt class="col-sm-3">Category</dt>
              <dd class="col-sm-9">{{ $product->category->name }}</dd>
              <dt class="col-sm-3">Key</dt>
              <dd class="col-sm-9">{{ $product->key }}</dd>
              <dt class="col-sm-3">Name</dt>
              <dd class="col-sm-9">{{ $product->name }}</dd>
            </dl>
        </div>
    </div>