<div style="color:#737373;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left">

  <p style="margin:0 0 16px">Hi. Your order at XXX has been success. Please check the detail below to confirm your information:
  </p>

  <h2 style="color:557da1;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">
    Your order #{{ $order_id }} {{ date('d/m/Y - H:i:s') }}</h2>

  <div style="margin-bottom:40px">
    <table cellspacing="0" cellpadding="6"
      style="width:100%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;color:#737373;border:1px solid #e4e4e4;vertical-align:middle"
      border="1">
      <thead>
        <tr>
          <th scope="col"
            style="text-align:left;color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px">
            Name</th>
          <th scope="col"
            style="text-align:left;color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px">
            Airport</th>
          <th scope="col"
            style="text-align:left;color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px">
            Email</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td
            style="text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;border:1px solid #e4e4e4;padding:12px">
            {{ $full_name }}</td>
          <td
            style="text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;color:#737373;border:1px solid #e4e4e4;padding:12px">
            {{ $airport_arrival }} </td>
          <td
            style="text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;color:#737373;border:1px solid #e4e4e4;padding:12px">
            <span>{{ $mail }}</span> </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th scope="row" colspan="2"
            style="text-align:left;border-top-width:4px;color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px">
            Total:</th>
          <td
            style="text-align:left;border-top-width:4px;color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px">
            <span>{{ $total_money }}<span>₫</span></span></td>
        </tr>
        <tr>
          <th scope="row" colspan="2"
            style="text-align:left;color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px">
            Date of departure:</th>
          <td
            style="text-align:left;color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px">
            {{ $date_of_departure }}</td>
        </tr>
        <tr>
          <th scope="row" colspan="2"
            style="text-align:left;color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px">
            Date of arrival:</th>
          <td
            style="text-align:left;color:#737373;border:1px solid #e4e4e4;vertical-align:middle;padding:12px">
            {{ $date_of_arrival }}</td>
        </tr>
      </tfoot>
    </table>
  </div>

  <table cellspacing="0" cellpadding="6"
    style="width:100%;border:1px solid #eee" border="1">
    <thead>
      <tr>
        <th scope="col"
          style="text-align:left;border:1px solid #eee;padding:12px">Name</th>
        <th scope="col"
          style="text-align:left;border:1px solid #eee;padding:12px">Gender</th>
        <th scope="col"
          style="text-align:left;border:1px solid #eee;padding:12px">Nationality</th>
        <th scope="col"
          style="text-align:left;border:1px solid #eee;padding:12px">Passport number</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($children as $index => $eachDetail)
      <tr>
        <th scope="col"
          style="text-align:center;border:1px solid #eee;padding:12px">{{ $eachDetail['passport_full_name'] }}</th>
        <th scope="col"
          style="text-align:center;border:1px solid #eee;padding:12px">{{ $eachDetail['passport_gender'] }}</th>
        <th scope="col"
          style="text-align:center;border:1px solid #eee;padding:12px">{{ $eachDetail['nationality'] }}</th>
        <th scope="col"
          style="text-align:center;border:1px solid #eee;padding:12px">{{ $eachDetail['passport_number'] }}</th>
      </tr>
      @endforeach
    </tbody>
  </table>
  <table id="m_6031601360345530093addresses" cellspacing="0" cellpadding="0"
    style="width:100%;vertical-align:top;margin-bottom:40px;padding:0"
    border="0">
    <tbody>
      <tr>
        <td
          style="text-align:left;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;border:0;padding:0"
          valign="top" width="50%">
          <h2
            style="color:557da1;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">
            Contact information</h2>

          <address
            style="padding:12px 12px 0;color:#737373;border:1px solid #e4e4e4">
            Company name<br>Company location <br>Company province<br>Company City <br>Company phone <p style="margin:0 0 16px"><a
                href="mailto:nhandq.dev@gmail.com"
                target="_blank">Company@mail.comtact.com</a></p>
          </address>
        </td>
      </tr>
    </tbody>
  </table>
</div>
