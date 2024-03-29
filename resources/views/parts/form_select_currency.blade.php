<form class="form-inline" method="get" action="/select-currency">
  @csrf
  <div class="form-group row mx-2" >
    @php
      $crc = Session::has('currency')?Session::get('currency'):'MXN';
    @endphp

    <label for="currency" class="col-sm-10 col-form-label col-form-label-sm">TC: ${{ number_format(getTipoCambioActual(),2) }}</</label>

    <div class="col-sm-2">
      <select class="form-control form-control-sm" id="currency" name="currency" onchange="this.form.submit()">
        <option value="MXN" {{  $crc=='MXN'?'selected':'' }}>MXN</option>
        <option value="USD" {{  $crc=='USD'?'selected':'' }}>USD</option>
      </select>
    </div>
  </div>
</form>
