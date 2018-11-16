@component('mail::message')
# New Loan enquiry from Dollar Dollar.


@component('mail::table')
<table>
    @if($data['full_name'])
        <tr>
            <td>Fullname</td>
            <td>:</td>
            <td>{{$data['full_name']}}</td>
        </tr>
    @endif
    @if($data['email'])
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{$data['email']}}</td>
        </tr>
    @endif
    @if($data['telephone'])
        <tr>
            <td>Contact number</td>
            <td>:</td>
            <td>{{$data['country_code']}} &emsp;{{$data['telephone']}}</td>
        </tr>
    @endif
    @if(count($data['product_names']))
        <tr>
            <td>Products</td>
            <td>:</td>
            <td>{{implode(', ',$data['product_names']) }}</td>
        </tr>
    @endif

    @if($data['rate_type_search'])
        <tr>
            <td>Rate type</td>
            <td>:</td>
            <td>{{$data['rate_type_search']}}</td>
        </tr>
    @endif

    @if($data['loan_amount'])
        <tr>
            <td>Loan amount</td>
            <td>:</td>
            <td>{{$data['loan_amount']}}</td>
        </tr>
    @endif

    @if($data['loan_type'])
        <tr>
            <td>Loan type</td>
            <td>:</td>
            <td>{{$data['loan_type']}}</td>
        </tr>
    @endif


</table>
@endcomponent

@component('mail::button', ['url' => env('APP_URL').'/admin'])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
