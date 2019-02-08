@extends('layouts.user.account')

@section('title', 'Billing')

@section('tabcontent')
    <div class="container">
        <div class="tab-pane active">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Billing History</h3>
                    <hr>
                    <div class="billing-scroll">
                        <table class="table table-striped">
                            <thead>
                            <tr class="active">
                                <th class="hidden-sm hidden-xs">ID</th>
                                <th>Transaction Date</th>
                                <th>Description</th>
                                <th>Amount (USD)</th>
                                <th>Service</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td class="hidden-sm hidden-xs">
                                        {{ $transaction->id }}
                                    </td>
                                    <td>
                                        {{ $transaction->created_at->timezone(\Illuminate\Support\Facades\Auth::user()->timezone) }}
                                    </td>
                                    <td>
                                        {{ $transaction->description }}
                                    </td>
                                    <td>
                                        ${{ $transaction->amount }}
                                    </td>
                                    <td>
                                        {{ $transaction->service }}
                                    </td>
                                    <td>
                                        {{ $transaction->status_transaction }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center"><h2>Data is empty...</h2></td>
                                </tr>
                            @endforelse
                            </tbody>
                            <tfoot>
                            <td colspan="6">
                                <ul class="pagination pull-right">
                                    {{$transactions->links()}}
                                </ul>
                            </td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection