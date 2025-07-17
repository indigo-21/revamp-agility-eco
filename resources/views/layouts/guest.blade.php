<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/icon.png') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .building-bg {
            position: relative;
        }

        .building-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ asset('assets/images/login-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            /* filter: blur(3px); */
            z-index: 1;
        }

        .building-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            z-index: 2;
        }

        .building-silhouette {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.6) 50%, transparent 100%);
            clip-path: polygon(0 100%, 0 60%, 15% 45%, 25% 55%, 35% 40%, 50% 50%, 65% 35%, 80% 45%, 100% 30%, 100% 100%);
        }

        .form-container {
            background: rgba(45, 55, 72, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(231, 73, 58, 0.2);
            border-radius: 1rem;
            padding: 2rem;
            max-width: 28rem;
            width: 100%;
        }

        .input-field {
            background: rgba(74, 85, 104, 0.8);
            border: 1px solid rgba(231, 73, 58, 0.3);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            width: 100%;
            transition: all 0.2s ease;
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .input-field:focus {
            background: rgba(74, 85, 104, 0.9);
            border-color: #e7493a;
            box-shadow: 0 0 0 3px rgba(231, 73, 58, 0.3);
            outline: none;
        }

        .label-field {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }

        label, span {
            color: white !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #e7493a 0%, #f4844a 50%, #d84a85 100%);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(231, 73, 58, 0.4);
            background: linear-gradient(135deg, #d8432f 0%, #e9743f 50%, #c7426d 100%);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid rgba(231, 73, 58, 0.4);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary:hover {
            background: rgba(231, 73, 58, 0.1);
            border-color: rgba(231, 73, 58, 0.6);
            color: white;
            text-decoration: none;
        }

        .checkbox-field {
            background: rgba(74, 85, 104, 0.8);
            border: 1px solid rgba(231, 73, 58, 0.3);
            border-radius: 0.25rem;
        }

        .checkbox-field:checked {
            background: #e7493a;
            border-color: #e7493a;
        }

        .error-message {
            color: #f87171;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .status-message {
            color: #34d399;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(52, 211, 153, 0.1);
            border: 1px solid rgba(52, 211, 153, 0.3);
            border-radius: 0.5rem;
        }

        /* Custom flex proportions */
        .landscape-flex {
            flex: 2;
        }

        .form-flex {
            flex: 1;
        }

        /* Content visibility enhancement */
        .welcome-content {
            position: relative;
            z-index: 50;
        }

        .welcome-content h2 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .welcome-content p {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .split-layout {
                flex-direction: column;
            }

            .landscape-section {
                height: 40vh;
                min-height: 300px;
                flex: none;
            }

            .form-section {
                padding: 1rem;
                flex: 1;
            }

            .form-container {
                padding: 1.5rem;
                margin: 0;
            }

            .building-silhouette {
                height: 50%;
            }

            .welcome-content h2 {
                font-size: 1.75rem;
            }

            .welcome-content p {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .landscape-section {
                height: 35vh;
                min-height: 250px;
                flex: none;
            }

            .form-container {
                padding: 1rem;
            }

            .welcome-content h2 {
                font-size: 1.5rem;
            }

            .welcome-content p {
                font-size: 0.875rem;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex split-layout">
        <!-- Left Side - building Landscape -->
        <div class="landscape-flex building-bg relative overflow-hidden landscape-section">
            <!-- Welcome Content - Centered with Logo -->
            <div class="absolute inset-0 flex items-center justify-center z-30">
                {{-- <div class="text-white text-center max-w-md welcome-content">
                    <!-- Logo -->
                    <div class="mb-8">
                        <x-application-logo class="text-white mx-auto" />
                    </div>
                    
                    <!-- Welcome Text -->
                    <h2 class="text-3xl font-bold mb-2">Capturing Moments</h2>
                    <p class="text-white/80 text-lg">Creating Memories</p>
                </div> --}}
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="form-flex bg-gray-800 flex items-center justify-center p-8 form-section">
            <div class="w-full max-w-md flex flex-col items-center">
                <!-- Logo above form -->
                <div class="mb-8">
                    <x-application-logo class="mb-4"/>
                </div>
                
                <!-- Form container -->
                <div class="form-container">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
