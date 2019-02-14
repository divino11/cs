@extends('layouts.user.account')

@section('title', 'Billing')

@section('tabcontent')
    <div class="tab-pane active" id="billing">
        <div class="settings-section settings-credits-section">
            <table class="table table-striped settings-billing-module">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Transaction date</th>
                    <th scope="col">Description</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Service</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <th scope="row">{{ $transaction->id }}</th>
                        <td>{{ $transaction->created_at->timezone(\Illuminate\Support\Facades\Auth::user()->timezone) }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>${{ $transaction->amount }}</td>
                        <td>{{ $transaction->service }}</td>
                        <td><span class="badge badge-secondary badge-{{current($transaction->status_transaction)}}">{{ key($transaction->status_transaction) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center"><h2>Data is empty...</h2></td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <ul class="pagination pull-right">
                {{$transactions->links()}}
            </ul>
        </div>
    </div>
@endsection