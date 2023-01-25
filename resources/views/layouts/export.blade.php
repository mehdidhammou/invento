<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    {{-- <style>
        .p-4 {
            padding: 1rem;
        }

        .w-full {
            width: 100%;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .gap-8 {
            gap: 2rem;
        }

        .flex-col {
            flex-direction: column;
        }

        .justify-start {
            justify-content: flex-start;
        }

        .p-8 {
            padding: 2rem;
        }

        .justify-between {
            justify-content: space-between;
        }

        .relative {
            position: relative;
        }

        .overflow-x-auto {
            overflow-x: auto;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-left {
            text-align: left;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        .text-gray-700 {
            color: #374151;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .bg-gray-50 {
            background-color: #f9fafb;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .bg-white {
            background-color: #fff;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .w-screen {
            width: 100vw;
        }
    </style> --}}

    @vite(['resources/css/app.css'])
</head>

<body class="antialiased">
    <div class="flex items-center w-full flex-col gap-12 justify-start py-16">
        <div class="flex w-full items-center justify-between">
            <h1 class="font-semibold text-5xl tracking-widest">
                Invento
                <span class="text-blue-400">.</span>
            </h1>
        </div>
        <hr class="w-full bg-gray-600">
        <div class="w-full">
            {{ $slot }}
        </div>
        <div class="w-full flex items-center justify-end">
            {{-- print --}}
            <button class="bg-blue-400 text-white px-4 py-2 rounded-md" id="print-button" onclick="printDocument()">
                Print
            </button>
        </div>
    </div>
    <script>
        function printDocument() {
            // temporary hide the print button
            document.getElementById('print-button').style.display = 'none';
            // print the document
            window.print();
            // show the print button
            document.getElementById('print-button').style.display = 'block';

        }
    </script>
</body>

</html>
