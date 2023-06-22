<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<link rel="stylesheet" href="{{asset('css/pdf.css')}}">

	</head>

	<body>
		<div class="invoice-box" style="overflow-x: auto;">
			<table>
			<tr class="top">
	<td colspan="4">
		<table>
			<tr>
				<td class="title">
					<img src="{{ asset('img/logo.png') }}" style="width: 100%; max-width: 300px" />
				</td>
				<td class="right-align">
					ID da Encomenda: {{ $encomendaData->id }}<br />
					Criada a: {{$encomendaData->date}}<br />
				</td>
			</tr>
		</table>
	</td>
</tr>

<tr class="information">
	<td colspan="4">
		<table>
			<tr>
				<td>
					ImagineShirt, Inc.<br />
					Rua General Norton de Matos<br />
					Apartado 4133,
					2411-901 Leiria – Portugal
					<br>Notas: {{ $encomendaData->notes }}
				</td>

				<td class="right-align">
					{{ $encomendaData->name }}<br />
					{{ $encomendaData->address }}<br />
					NIF: {{ $encomendaData->nif }}<br />
					Email: {{ $encomendaData->email }}
				</td>
			</tr>
		</table>
	</td>
</tr>


				<tr class="heading">
					<td>Metodo de pagamento</td>
					<td></td>
					<td></td>
					<td class="right-align">
                    @if ($encomendaData->payment_type == 'MC')
                        MasterCard
                    @else
                        {{ $encomendaData->payment_type }}
                    @endif
                    </td>
				</tr>

				<tr class="details">
					<td>Referência pagamento</td>
					<td></td>
					<td></td>
					<td class="right-align">{{ $encomendaData->payment_ref }}</td>
				</tr>

				<tr class="heading">
					<td>Item</td>
					<td>Preço unitário</td>
					<td class="right-align">Quantidade</td>
					<td class="right-align">Total</td>
				</tr>

				@php
                    $customer_tshirt = 0;
                    $catalogo_tshirt = 0;
                @endphp

                    @foreach ($itemsData as $item)
                        <tr class="item">
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->unit_price }}€</td>
							<td class="right-align">{{ $item->qty }}</td>
							<td class="right-align">{{ $item->sub_total}}€</td>
                        </tr>

					@if (!is_null($item->customer_id) && $item->qty >= $quantdesconto)
                        @php
                            $customer_tshirt= $customer_tshirt + $item->qty;
                        @endphp
                    @endif

                    @if (is_null($item->customer_id) && $item->qty >= $quantdesconto)
                        @php
                            $catalogo_tshirt = $catalogo_tshirt + $item->qty;
                        @endphp
                    @endif
					
                    @endforeach
					<tr class="total">
						<td></td>
						<td></td>
						<td></td>
						<td class="right-align"><span>
								Total s/ desconto: {{$encomendaData->total_price + (($catalogo_tshirt * $descontocatalogo)+($customer_tshirt * $descontoown))}}€
							<br>Desconto: {{($catalogo_tshirt * $descontocatalogo)+($customer_tshirt * $descontoown) }} €
							<br>Total: {{ $encomendaData->total_price }}€</span>
						</td>
                	</tr>
			</table>
		</div>
	</body>
</html>