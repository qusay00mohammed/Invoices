<table>
<thead>
  <tr>
    <th>Invoice number</th>
    <th>Invoice Date</th>
    <th>Due Date</th>
    <th>Product</th>
    <th>Section Name</th>
    <th>Amount Collection</th>
    <th>Amount Commission</th>
    <th>Discount</th>
    <th>Rate Vat</th>
    <th>Value Vat</th>
    <th>total</th>
    <th>Status</th>
    <th>note</th>
    <th>Payment Date</th>
  </tr>
</thead>

<tbody>
  @foreach ($invoices as $invoice)
      <tr>
        <td>{{ $invoice->invoice_num }}</td>
        <td>{{ $invoice->invoice_date }}</td>
        <td>{{ $invoice->due_date }}</td>
        <td>{{ $invoice->product }}</td>
        <td>{{ $invoice->section->section_name }}</td>
        <td>{{ $invoice->amount_collection }}</td>
        <td>{{ $invoice->amount_commission }}</td>
        <td>{{ $invoice->discount }}</td>
        <td>{{ $invoice->rate_vat }}</td>
        <td>{{ $invoice->value_vat }}</td>
        <td>{{ $invoice->total }}</td>
        <td>{{ $invoice->status }}</td>
        <td>{{ $invoice->note }}</td>
        <td>{{ $invoice->payment_date }}</td>
      </tr>
  @endforeach
</tbody>
</table>
