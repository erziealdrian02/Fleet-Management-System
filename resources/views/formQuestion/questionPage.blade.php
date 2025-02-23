<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Interface</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-indigo-500 p-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header with Timer -->
        <div class="flex justify-end items-center text-white mb-4">
            <i data-lucide="clock" class="w-5 h-5 mr-2"></i>
            <span>0 Jam 42 Menit 12 Detik</span>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg p-6 shadow-lg">
            <!-- Question Number -->
            <div class="mb-6">
                <div class="inline-flex items-center">
                    <span class="text-sm text-gray-600">SOAL NO</span>
                    <div class="w-6 h-6 bg-indigo-500 rounded-full flex items-center justify-center text-white text-sm ml-2">
                        {{ $index + 1 }}
                    </div>
                </div>
            </div>

            <!-- Question Text -->
            <div class="mb-8">
                <p class="text-gray-800">
                    {{ $question->question }}
                </p>
            </div>

            <!-- Answer Options -->
            <div class="space-y-4">
                @foreach (['a', 'b', 'c', 'd'] as $option)
                    <div class="flex items-center">
                        <input type="radio" name="answer" id="answer{{ $option }}" value="{{ $option }}" 
                            class="mr-3"
                            {{ isset($savedAnswers[$index]) && $savedAnswers[$index] == $option ? 'checked' : '' }}
                            onchange="saveAnswer({{ $index }}, '{{ $option }}')">
                        <label for="answer{{ $option }}" class="text-gray-700">{{ $question['option_' . $option] }}</label>
                    </div>
                @endforeach
            </div>


            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-between">
                @if ($index > 0)
                    <a href="{{ route('quiz.page', [$driver->id, $driver->license_number, 'index' => $index - 1]) }}" 
                    class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">
                        Sebelumnya
                    </a>
                @endif

                @if ($index < $totalQuestions - 1)
                    <a href="{{ route('quiz.page', [$driver->id, $driver->license_number, 'index' => $index + 1]) }}" 
                    class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">
                        Selanjutnya
                    </a>
                @else
                    <a href="{{ route('quiz.finish', [$driver->id, $driver->license_number]) }}" 
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        Selesai
                    </a>
                @endif
            </div>



            <!-- Question Navigation -->
            <div class="mt-8 bg-gray-50 p-4 rounded-lg">
                <div class="grid grid-cols-8 gap-2">
                    @foreach (range(1, $totalQuestions) as $num)
                        <a href="{{ route('quiz.page', [$driver->id, $driver->license_number, 'index' => $num - 1]) }}"
                        class="w-8 h-8 {{ $index + 1 == $num ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700' }} 
                                rounded flex items-center justify-center">
                            {{ $num }}
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>

    <script>
        function saveAnswer(index, answer) {
            fetch("{{ route('quiz.saveAnswer') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    driver_id: "{{ $driver->id }}",
                    index: index,
                    answer: answer
                })
            }).then(response => response.json())
            .then(data => console.log("Jawaban tersimpan: ", data));
        }
    </script>
</body>
</html>
