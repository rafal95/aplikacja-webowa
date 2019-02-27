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
							<div class="col-md-6">
									<div class="card">
											<div class="card-header">{{ __(' ') }}</div>
			
											<div class="card-body">
													<div class="container content">
														<div class="row justify-content-sm-center ">
														
														<div class="col-sm-auto">
															<a class="btn btn-secondary" style="margin-bottom:10px" href="/new_game" >Stwórz rozgrywkę</a>
														</div><div class="w-100"></div>
														
														<div class="col-sm-auto">
															<div class="dropdown">
																<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" style='margin-bottom:10px' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Zarządzaj rozgrywką</a>

																<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
																		@foreach($games as $rozgrywki)
																			<a class="dropdown-item"  href={{route('manage',$rozgrywki->id)}}>{{$rozgrywki->name}}</a>
																		@endforeach
																</div>
															</div>
														
														</div><div class="w-100"></div>
														
														<div class="col-sm-auto">
															<div class="dropdown">
																<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Podejrzyj rozgrywkę
																</button>
													
																<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
																	@foreach($games as $rozgrywki)
																		<a class="dropdown-item" href={{route('pages.show_game',$rozgrywki->id)}}>{{$rozgrywki->name}}</a>
																	@endforeach
																</div>
															</div>
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