<table class="table table-bordered">
<thead>
<tr>
<th>User Details</th>
<th>Consent</th>
<th>Bank Name</th>
<th>Account Name</th>
<th>Deposit Amount</th>
<th>End Date</th>
<th>Status</th>
</tr>
</thead>
<tbody>
@if(count($customer_reports_groups))
@foreach($customer_reports_groups as $customer_reports_group)
@php
$crs = $customer_reports->where('users_id', $customer_reports_group->users_id);
@endphp
<tr>
<td rowspan="<?php if($crs->count()==0) { echo '1'; } else { echo $crs->count(); } ?>"><?php echo ucfirst($customer_reports_group->first_name) . ' ' . ucfirst($customer_reports_group->last_name) . ' - ' . $customer_reports_group->email . ' - ' . $customer_reports_group->country_code . $customer_reports_group->tel_phone; ?></td>
<td rowspan="<?php if($crs->count()==0) { echo '1'; } else { echo $crs->count(); } ?>"><?php if($customer_reports_group->subscribe==1) {echo 'Yes';} else {echo 'No';} ?></td>
{{ Helper::getCustomerReportData($customer_reports_group->users_id) }}
@endforeach
@else
<tr>
<td class="text-center" rows=8>No data found.</td>
</tr>
@endif
</tbody>
</table>