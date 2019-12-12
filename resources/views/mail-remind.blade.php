
<div class="gmail_quote">
  <blockquote class="gmail_quote"
    style="margin:0px 0px 0px 0.8ex;border-left:1px solid rgb(204,204,204);padding-left:1ex">
    <div style="border:1px solid rgb(0,0,0)">
      <span class="HOEnZb">
      </span>
      <table cellspacing="5" cellpadding="5" border="0" bgcolor="#ffffc0" align="center" width="100%">
        <tbody>
          <tr>
            <td>
              <strong>Dear <em>{{ isset($full_name) ? $full_name : 'Bạn' }}</em>,</strong>
            </td>
          </tr>
          <tr>
            <td>Thank you for ordering our Visa Service. This is
              confirmation from us to show that we have received your
              order request from
              <a href="#" target="_blank"/>&nbsp;and your payment was
              pending. For secure reason, we accept payment from third
              party only as: Credit/ Debit Card, Paypal or Bank
              Transfer<br>
              <h3>A. Payment Methods:</h3>
              <h4>1. Payment online:</h4>
              <p>Your payment can be accepted through Debit/ Credit Card or Paypal Gateway. <a
                  style="background:rgb(195,38,21);display:inline-block;color:rgb(255,255,255);text-decoration:none;border-radius:6px;border:0px;font-weight:bold;line-height:1;font-size:16px;padding:8px 14px 9px;width:180px;text-align:center"
                  href="{{ $paymentLink }}"
                  target="_blank">
                  <strong>MAKE PAYMENT NOW</strong></a></p>

              <h3>B. Your order:
                <strong style="color:rgb(255,0,0);font-size:larger">#{{ $order_id }}</strong>
              </h3>
              <table width="100%" border="1" cellpadding="5" style="border-collapse:collapse" bgcolor="#FFFFFF">
                <tbody>
                  <tr>
                    <td style="width:400px">
                      <strong>Order Date</strong>
                    </td>
                    <td>{{ $order_date }}</td>
                  </tr>
                  <tr>
                    <td>
                      <strong>Visa Type</strong></td>
                    <td>(<strong>{{ ($purpose == 'other') ? 'Khác' : (($purpose == 'tourist visa') ? 'Du lịch' : 'Công tác') }}</strong>)</td>
                  </tr>
                  <tr>
                    <td><strong>Arrival Date</strong></td>
                    <td>{{ $date_of_arrival }}</td>
                  </tr>
                  <tr>
                    <td><strong>Exit Date</strong></td>
                    <td>{{ $date_of_departure }}</td>
                  </tr>
                  <tr>
                    <td><strong>Airport of arrival</strong></td>
                    <td>{{ $airport_arrival }}</td>
                  </tr>
                  <tr>
                    <td><strong>Number of Applicants</strong></td>
                    <td>{{ count($orderDetail) }}</td>
                  </tr>
                  <tr>
                    <td><strong>Visa Service Fees</strong></td>
                    <td>{{ $total_money/count($orderDetail) }}</td>
                  </tr>

                  <tr>
                    <td><strong>Total Visa Service Fees</strong></td>
                    <td>{{ ($service_fee == 0) ? 0 : $service_fee.'.000đ' }}</td>
                  </tr>
                  <tr>
                    <td><strong>{{ $process_type }}</strong></td>
                    <td>${{ ($process_type == 'normal') ? 0 : (($process_type == 'urgent') ? 19000 : 25000)}}</td>
                  </tr>

                  <tr>
                    <td><strong>Special Request</strong></td>
                    <td>

                    </td>
                  </tr>

                  <tr>
                    <td><strong>Total</strong></td>
                    <td><strong
                        style="color:rgb(255,0,0);font-size:22px">{{ $total_money }}</strong>
                    </td>
                  </tr>
                </tbody>
              </table>
              <br>
              <strong>DETAIL OF APPLICANTS:</strong>
              <table width="100%" border="1" cellpadding="5"
                style="border-collapse:collapse;text-align:center"
                bgcolor="#FFFFFF">
                <tbody>
                  <tr>
                    <td style="width:50px"><strong>No</strong></td>
                    <td><strong>Full Name</strong></td>
                    <td><strong>Gender</strong></td>
                    <td><strong>Birthday</strong></td>
                    <td><strong>Nationality</strong></td>
                    <td><strong>Passport</strong></td>
                    <td><strong>Visa Type</strong></td>
                    <td><strong>Visa Fee</strong></td>
                    <td><strong>Full Package Services</strong></td>
                  </tr>
                @foreach ($orderDetail as $index => $eachDetail)
                  <tr>
                    <td>{{ $index }}</td>
                    <td>{{ $eachDetail['name'] }}</td>
                    <td>{{ $eachDetail['gender'] }}</td>
                    <td>{{ $eachDetail['birthday'] }}</td>
                    <td>{{ $eachDetail['nationality'] }}</td>
                    <td>{{ $eachDetail['passportNumber'] }}</td>
                    <td>(<strong>{{ $purpose }}</strong>)</td>
                    <td>{{ $total_money/count($orderDetail) }}</td>
                    <td>{{ ($service_fee == 0) ? 0 : $service_fee.'.000đ' }}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
              <br>
              <strong>ACCOUNT INFORMATION:</strong>
              <table width="100%" border="1" cellpadding="5" style="border-collapse:collapse" bgcolor="#FFFFFF">
                <tbody>
                  <tr>
                    <td><strong>ID</strong></td>
                    <td><strong
                        style="color:rgb(255,0,0);font-size:larger">#{{ $order_id }}</strong>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:200px"><strong>Full Name</strong>
                    </td>
                    <td>{{ $full_name }}</td>
                  </tr>
                  <tr>
                    <td><strong>Email</strong></td>
                    <td><a href="#"
                        target="_blank"> </a></td>
                  </tr>
                  <tr>
                    <td><strong>Country</strong></td>
                    <td>Vietnam</td>
                  </tr>
                  <tr>
                    <td><strong>Address</strong></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><strong>Telephone</strong></td>
                    <td>+84969765629</td>
                  </tr>
                </tbody>
              </table>
              <p>
                <strong><em>Best Regards,</em></strong><br><br>
                <strong>Vietnam Immigration Services Team.</strong><br>
                <strong>WE ARE BESIDE YOU 24/7.</strong>
              </p>
            </td>
          </tr>
          <tr>
            <td colspan="5" style="border-top:1px solid rgb(102,102,102)">
              <p>
                <em>VietnamImmigration is a commercial website, operated
                  by Vietnam Immigration Services Team. We are not the
                  Embassy/Consulate or the representative of any
                  government department of Vietnam.</em><br><br>
                <em>If you choose to utilize our services please be
                  advised that, we charge a handling fee for visa
                  services, these services include consultation, providing
                  advice on the requirements, taking responsibility for
                  ensuring that your documentation is correct, and sending
                  a courier to queue up on your behalf to obtain the visa
                  to Vietnam. In additional, you have to pay Stamping fee
                  when you come to Vietnam.</em><br><br>
                <em>This email and any files transmitted with it are
                  confidential and intended solely for the use of the
                  individual or entity to whom they are addressed. If you
                  have received this email in error please notify the
                  system manager. This message contains confidential
                  information and is intended only for the individual
                  named. If you are not the named addressee you should not
                  disseminate, distribute or copy this email. Please
                  notify the sender immediately by email if you have
                  received this email by mistake and delete this email
                  from your system. If you are not the intended recipient
                  you are notified that disclosing, copying, distributing
                  or taking any action in reliance on the contents of this
                  information is strictly prohibited.</em><br><br>
                <em>All content within the email for reference purposes
                  only. We are consulting company based on customer
                  requirements, the advice given is based on the law of
                  the host country. Therefore, we do not assume any
                  liability from customers's activities when they violate
                  the rules or cheating involved in the home
                  country.</em><span class="HOEnZb">
                  <font color="#888888">
                  </font>
                </span></p><span class="HOEnZb">
                <font color="#888888">
                </font>
              </span>
            </td>
          </tr>
        </tbody>
      </table>
      </span>
    </div>
  </blockquote>
</div>
