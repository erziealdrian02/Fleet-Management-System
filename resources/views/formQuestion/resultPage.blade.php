<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuis</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
        <h1 class="text-2xl font-bold mb-4">Hasil Kuis</h1>
        <p class="text-lg mb-4">Pengemudi: <strong>{{ $driver->name }}</strong></p>
        <p class="text-lg mb-4">Skor Anda: <span class="text-3xl font-bold text-green-600">{{ $score }}</span></p>

        <a href="/question" class="mt-6 px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">
            Kembali ke Dashboard
        </a>
    </div>
</body>
</html>
