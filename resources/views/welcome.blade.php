<!DOCTYPE html>
<html class="h-full" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Onemission Admin</title>
    @vite('resources/css/app.scss')
</head>
<body class="antialiased flex h-full text-base text-gray-700 dark:bg-coal-500">
    <style>
   .page-bg {
			background-image: url('assets/media/images/2600x1200/bg-10.png');
		}
		.dark .page-bg {
			background-image: url('assets/media/images/2600x1200/bg-10-dark.png');
		}
  </style>
  <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg">
   <div class="card max-w-[370px] w-full">
    <form action="#" class="card-body flex flex-col gap-5 p-10" id="sign_in_form" method="get">
     <div class="text-center mb-2.5">
      <h3 class="text-lg font-medium text-gray-900 leading-none mb-2.5">
       Sign in
      </h3>
     </div>
     <div class="flex flex-col gap-1">
      <label class="form-label font-normal text-gray-900">
       Email
      </label>
      <input class="input" placeholder="email@email.com" type="text" value=""/>
     </div>
     <div class="flex flex-col gap-1">
      <div class="flex items-center justify-between gap-1">
       <label class="form-label font-normal text-gray-900">
        Password
       </label>
      </div>
      <div class="input" data-toggle-password="true">
       <input name="user_password" placeholder="Enter Password" type="password" value=""/>
       <button class="btn btn-icon" data-toggle-password-trigger="true" type="button">
        <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden">
        </i>
        <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block">
        </i>
       </button>
      </div>
     </div>
     <a href="{{ route('overview') }}" class="btn btn-primary flex justify-center grow">
      Sign In
     </a>
     {{-- <button class="btn btn-primary flex justify-center grow">
      Sign In
     </button> --}}
    </form>
   </div>
  </div>
    @vite('resources/js/app.js')
</body>
</html>