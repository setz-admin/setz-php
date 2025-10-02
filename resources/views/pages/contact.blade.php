@extends('layouts.public')

@section('title', 'Kontakt - EDV Integration Dr. Setz')

@section('content')
    <div class="prose prose-gray max-w-none">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Kontakt</h1>

        <div class="text-gray-700 space-y-6">
            <p class="text-lg">
                Wir freuen uns auf Ihre Kontaktaufnahme. Gerne besprechen wir mit Ihnen Ihre IT-Anforderungen
                und Projektvorhaben in einem unverbindlichen Gespräch.
            </p>

            <div class="grid md:grid-cols-2 gap-8 mt-8">
                <div class="bg-white border border-gray-200 rounded p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">EDV Integration Dr. Setz</h2>

                    <div class="space-y-3">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-1">Adresse</h3>
                            <p class="text-sm">
                                Dr.-Ing. Thomas Setz<br>
                                EDV-Integration Dr Setz<br>
                                Weierbacherstr. 65 a<br>
                                55743 Idar-Oberstein<br>
                                Deutschland
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-1">E-Mail</h3>
                            <a href="mailto:info@setz.de" class="text-sm text-blue-600 hover:text-blue-800">
                                info@setz.de
                            </a>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-1">Web</h3>
                            <a href="https://www.setz.de" class="text-sm text-blue-600 hover:text-blue-800">
                                www.setz.de
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-200 rounded p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Leistungen</h2>

                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start">
                            <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-1.5 mr-3"></span>
                            <span>DevOps Engineering & CI/CD</span>
                        </li>
                        <li class="flex items-start">
                            <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-1.5 mr-3"></span>
                            <span>Python Development & Automation</span>
                        </li>
                        <li class="flex items-start">
                            <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-1.5 mr-3"></span>
                            <span>Test-Driven Development & Quality Assurance</span>
                        </li>
                        <li class="flex items-start">
                            <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-1.5 mr-3"></span>
                            <span>Systemdesign & Systemintegration</span>
                        </li>
                        <li class="flex items-start">
                            <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-1.5 mr-3"></span>
                            <span>KI Unterstütze Entwicklung</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Anfrage stellen</h3>
                <p class="mb-3">
                    Für eine unverbindliche Anfrage oder ein persönliches Gespräch erreichen Sie uns am besten per E-Mail.
                    Wir melden uns zeitnah bei Ihnen zurück.
                </p>
                <a href="mailto:info@setz.de" class="inline-block px-6 py-2 bg-gray-900 text-white rounded hover:bg-gray-800 transition">
                    E-Mail senden
                </a>
            </div>

            <div class="mt-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Technische Expertise</h2>
                <p class="mb-4">
                    Unsere Mitarbeiter verfügen über umfangreiche Expertise in folgenden Bereichen:
                </p>

                <div class="grid md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-200 rounded p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Programmierung</h3>
                        <ul class="text-sm space-y-1 text-gray-700">
                            <li>• UNIX</li>
                            <li>• C/C++</li>
                            <li>• Java</li>
                            <li>• Python</li>
                        </ul>
                    </div>

                    <div class="bg-white border border-gray-200 rounded p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Systeme</h3>
                        <ul class="text-sm space-y-1 text-gray-700">
                            <li>• Betriebssysteme</li>
                            <li>• Datenbanken</li>
                            <li>• Middleware</li>
                            <li>• Netzwerke</li>
                        </ul>
                    </div>

                    <div class="bg-white border border-gray-200 rounded p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Methoden</h3>
                        <ul class="text-sm space-y-1 text-gray-700">
                            <li>• Projektmanagement</li>
                            <li>• Testdesign</li>
                            <li>• Optimierung</li>
                            <li>• Integration</li>
                        </ul>
                    </div>
                </div>
            </div>

            @include('components.certifications')
        </div>
    </div>
@endsection
