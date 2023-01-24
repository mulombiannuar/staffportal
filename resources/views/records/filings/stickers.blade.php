<html>

<head>
    <title> {{ $title }} | {{ config('app.name') }} </title>
    <style>
        body {
            text-align: center;
            font-size: 70px;
            font-family: "Source Sans Pro";

        }

        section {
            height: 200px;
            margin-top: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        section h2,
        h3 {
            display: inline-block;
            vertical-align: middle;
        }

        .footer-text {
            font-style: italic;
            font-size: 14px;
            border-top: solid #000;
            position: fixed;
            padding: 5px;
            padding-left: 20px;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 20px;
        }
    </style>
</head>

<body>
    @forelse ($files as $file)
        <main style="page-break-after: none">
            <section>
                <h2>{{ $file->file_label . ' - ' . $file->file_number }} <br><span
                        style="color: grey; font-size: 60%;">{{ strtoupper($type->type_name) }}</span> </h2>
            </section>
            <div class="footer-text">
                <small>Bimas Microfinance Kenya Limited &copy;
                    <?php echo date('Y'); ?> | Filing labels for {{ $type->type_name }} printed on
                    {{ date('F d, Y h:i:sa') }} by
                    {{ ucwords($user->name) }}
                </small>
            </div>
        </main>
    @empty
        <p style="font-size: 30px;">No files labels available for {{ $type->type_name }}</p>
    @endforelse
</body>

</html>
