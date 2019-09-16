@extends('layouts.app')

@section('content')
<div style="margin-top: 4.4rem">
<main class="main-content-inner">
	<div class="row">
		<div class="col-12 mt-5">
			<div class="card">
				<div class="card-body">
					<h4 class="header-title">Responsáveis</h4>
					<div class="data-tables datatable-dark">
						<table id="dataTable3" class="text-center">
							<thead class="text-capitalize">
								<tr>
									<th>Nome</th>
									<th>E-mail</th>
									<th>Celular</th>
									<th>Telefone</th>
									<th>Veio através</th>
									<th>Atendido Por</th>
									<th>Primeira Visita</th>
								</tr>
							</thead>
							<tbody>
								@foreach($responsaveis as $responsavel)
									<tr>
										<td>{{$responsavel['nome']}}</td>
										<td>{{$responsavel['contatos'][0]['email']}}</td>
										<td>{{$responsavel['contatos'][0]['celular']}}</td>
										<td>{{$responsavel['contatos'][0]['telefone']}}</td>
										<td>{{$responsavel['canal']['titulo']}}</td>
										<td>{{$responsavel['criado_por']['nome']}}</td>
										<td>{{$responsavel['created_at']}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
</div>

@endsection
