<div class="row mb-2">
	<div class="col-md-10">		
		@php 
			$show_tax=Session::has('show_tax')?Session::get('show_tax'):true;
		@endphp
		<form class="form-inline" method="post" action="/shopping-cart/change-show-tax">
			{{ csrf_field() }}				
			<label class="my-1 mr-2" for="select_show_tax">Mostar</label>
			<select class="custom-select my-1 mr-sm-2" id="select_show_tax" name="select_show_tax" onchange="this.form.submit()">
				<option value="with_tax" {{ $show_tax==true?'selected':''}}>Con IVA</option>
				<option value="tax_free" {{ $show_tax==false?'selected':''}}>Sin IVA</option>
			</select>							
		</form>
	</div>
</div>
