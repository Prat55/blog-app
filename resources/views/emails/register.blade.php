</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased text-gray-900">

    <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0 dark:bg-gray-900">

        <div
            class="w-full px-6 py-4 mt-6 overflow-hidden text-white bg-white shadow-md sm:max-w-md dark:bg-gray-800 sm:rounded-lg">

            <h1 class="text-center">Hii, {{ $mailData['name'] }}</h1>
            <p>Congratulations for successfull registration on bloggers heaven.</p>
            <p>Now you can share your thoughts to world, for make world better!</p>

        </div>

    </div>

</body>

</html>
