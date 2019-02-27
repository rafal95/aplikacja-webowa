@extends('layouts.app')

@section('content')
<!doctype html>
<html lang="en">
  <head>
    <title>Hello, world!</title>
  </head>

  <body>
			<div class="container">
					<div class="row justify-content-center">
							<div class="col-md-8">
									<div class="card">
											<div class="card-header">{{ __('Nowa rozgrywka') }}</div>
			
											<div class="card-body">
												<div class="container content">
												<!--<form action = "insert" method = "post">-->

													<div class="row">
														<div class="col-sm-8">
															<!--<form>-->
															{{Form::open(array('method'=>'post'))}}
																<div class="form-group row ">
																	<label for="nazwa" class="col-sm-4 col-form-label">Nazwa rozgrywki</label>
																	<div class="col-sm-8">
																		<input type="text" class="form-control" id="name" placeholder="Nazwa" name="name">
																	</div>
																</div>
													
																<div class="form-group row">
																	<label for="exampleFormControlSelect1" class="col-sm-4 col-form-label">Typ</label>
																	<div class="col-sm-8">
																		<select class="form-control" id="typ" name="typ" onClick="if(this.value=='Puchar'){losuj.disabled=false;}else{losuj.disabled=true;}">
																			<option>Liga</option>
																			<option>Puchar</option>
																		</select>
																	</div>
																</div>
																
																<div class="form-group row"></div>
																
																
																<div class="form-group row">			
																	<div class="col-sm-8 offset-sm-1">
																		<div class="w-100"></div>
																			<button type="submit" class="btn btn-primary" >Utwórz</button>
																<!-- <a href="/create" class="btn btn-primary">Utwórz</a>-->
																	</div>
																</div>
																
														</div>
													</div>
											<!--</form>-->
												{{Form::close()}}
												</div> 
											</div>
										</div>
								</div>
						</div>
				</div>											
  </body>
</html>
@endsection