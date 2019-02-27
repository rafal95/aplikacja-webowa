@extends('layouts.app')

@section('content')
<!doctype html>
<html lang="en">
  <head>
    <title>Hello, world!</title>
  </head>

  <body>
			<div class="container">
					<div class="row">
							<div class="col-md-5">
									<div class="card">
											<div class="card-header">{{ __('Dodaj drużyne') }}</div>
			
											<div class="card-body">
												<div class="container content">
												<!--<form action = "insert" method = "post">-->

													<div class="row">
														<div class="col-sm-12">
															<!--<form>-->
																{{Form::open(['route'=>'add_team.store'])}}
																<div class="form-group row ">
																	<label for="nazwa" class="col-sm-5 col-form-label">Nazwa druzyny</label>
																	<div class="col-sm-7">
																			<input type="text" class="form-control" name="team_name" id="team_name" placeholder="Nazwa druzyny">
																	</div>
																</div>
													
																<div class="form-group row">
																		<div class="col-sm-8 offset-sm-5">
																		@if(count($team) == 32 and $game->typ=='Puchar')
																			<button type="submit" class="btn btn-secondary" disabled="true">
																				Dodaj druzyne</button>
																			</div>
																		@else
																			<button type="submit" class="btn btn-secondary">
																				Dodaj druzyne</button>
																			</div>
																		@endif
																</div>
																
														</div>
													</div>
											<!--</form>-->
												{{Form::close()}}
												</div> 
											</div>
										</div>
										
										<div class ="row">
										<div class="col-md-12">										
										<div class="card">
											<div class="card-header">{{ __('Rozpocznij rozgrywkę') }}</div>
				
												<div class="card-body">
													<div class="container content">
													<!--<form action = "insert" method = "post">-->
														<div class="row">
															<div class="col-sm-12">
																	<div class="form-group row">			
																			<div class="col-sm-8 offset-sm-1">
																				<div class="w-100"></div>
																				@if(count($team) < 6 and $game->typ=='Puchar' )
																					<a  href="{{route('add_team.update',$game->id)}}" class="btn btn-primary disabled">Utwórz</a>
																				@else
																					<a  href="{{route('add_team.update',$game->id)}}" class="btn btn-primary">Utwórz</a>
																				@endif
																			</div>	
																	</div>
																	@if($game->typ=='Puchar')
																	<div class="form-group row ">
																		<label for="" style="color:red" class="col-sm-5 col-form-label">*Minimalnie 6 dryżyn</label>
																		<label for="" style="color:red" class="col-sm-5 col-form-label">*Maksymalnie 32 dryżyny</label>
																	</div>
																	@endif
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
								</div>
							</div>

								<div class="col-md-7">
										<div class="card">
												<div class="card-header">{{ __('Lista drużyn') }}</div>
				
												<div class="card-body">
													<div class="container content">	
															<div class="row">
																	<div class="col-sm-6" style="margin-top: 10px">
																			<table class="table table-hover">
																					<tr>
																							<th>Nazwa</th>
																							<th>Usuń</th>
																					</tr>
																				<?php $count = 0; ?>
																			@foreach($team as $druzyny)
																			<?php 
																				$count++;
																			?>
																				@if($count <= 8)
																				<tr>
																					<td><a class="btn btn-info">{{$druzyny->name}}</a></td>
																					<td><a href="add_team/delete/{{$druzyny->id}}"> <button class="btn btn-danger">X</button></a></td>	
																				</tr>
																				@endif
																			@endforeach
																			</table>
																</div>
														
																<div class="col-sm-6" style="margin-top: 10px">
																		<table class="table table-hover">
																				<tr>
																						<th>Nazwa</th>
																						<th>Usuń</th>
																				</tr>
																			<?php $count = 0; ?>
																		@foreach($team as $druzyny)
																		<?php 
																			$count++;
																		?>
																			@if($count > 8)
																			<tr>
																				<td><a class="btn btn-info">{{$druzyny->name}}</a></td>
																				<td><a href="add_team/delete/{{$druzyny->id}}"> <button class="btn btn-danger">X</button></a></td>
																			</tr>
																			@endif
																		@endforeach
																		</table>
																</div>
															</div>

													</div>
												</div>
										</div>
								</div>		

						</div>
				</div>										
	
  </body>
</html>
@endsection