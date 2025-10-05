@extends('layouts.public')

@section('title', 'Über Uns - EDV Integration Dr. Setz')

@section('content')
    <div class="prose prose-gray max-w-none">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Über Uns</h1>

        <div class="text-gray-700 space-y-6">
            <section>
                <h2 class="text-2xl font-semibold text-gray-900 mb-3">Unternehmen</h2>
                <p>
                    EDV Integration Dr. Setz wurde 1997 als Einzelunternehmen in Idar-Oberstein gegründet.
                </p>
            </section>


            <section>
                <h2 class="text-2xl font-semibold text-gray-900 mb-3">Philosophie</h2>
                <div class="bg-gray-50 border-l-4 border-gray-400 p-6 my-4">
                    <p class="text-lg italic">
                        "Wir sind technische Experten auf höchstem Niveau, die komplexe IT-Systeme bauen und integrieren.
                        Wir sind keine PowerPoint-Informatiker, sondern arbeiten mit Editor, Compiler und Betriebssystem."
                    </p>
                </div>
                <p>
                    Unser Ansatz basiert auf praktischer Expertise, enger Zusammenarbeit mit Kunden und der
                    Entwicklung einfacher Lösungen für komplexe Anforderungen.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-900 mb-3">Leistungen</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Kernleistungen</h3>
                        <ul class="list-disc list-inside space-y-2">
                            <li>IT-Beratung und Implementierung</li>
                            <li>Personalvermittlung im IT-Bereich</li>
                            <li>Langfristige Projektbesetzung</li>
                            <li>Softwareentwicklung und Wartung</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Beratungsleistungen</h3>
                        <ul class="list-disc list-inside space-y-2">
                            <li>Anwendungsarchitekturen</li>
                            <li>Systemdesign</li>
                            <li>Systemintegration</li>
                            <li>Testdesign</li>
                            <li>Organisation der Anwendungsentwicklung</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-900 mb-3">Technische Expertise</h2>
                <div class="bg-white border border-gray-200 rounded p-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Kompetenzen</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Programmierung & Systeme</h4>
                            <ul class="text-sm space-y-1">
                                <li>• UNIX-Expertise</li>
                                <li>• C/C++</li>
                                <li>• Java</li>
                                <li>• Python</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Methoden & Prozesse</h4>
                            <ul class="text-sm space-y-1">
                                <li>• Skalierungsanalyse & Optimierung</li>
                                <li>• Zuverlässigkeit & Testdesign</li>
                                <li>• Projektmanagement</li>
                                <li>• Technisches Design</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-4 bg-white border border-gray-200 rounded p-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Unterstützte Systemumgebungen</h3>
                    <div class="grid md:grid-cols-2 gap-3 text-sm">
                        <div>• Betriebssysteme</div>
                        <div>• Datenbanksysteme</div>
                        <div>• Programmiersprachen</div>
                        <div>• Middleware</div>
                        <div>• Netzwerke</div>
                    </div>
                </div>
            </section>

            @include('components.certifications')

            <section class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Interesse an einer Zusammenarbeit?</h3>
                <p class="mb-4">
                    Wir freuen uns auf Ihre Kontaktaufnahme für ein unverbindliches Gespräch.
                </p>
                <a href="{{ route('contact') }}" class="inline-block px-6 py-2 bg-gray-900 text-white rounded hover:bg-gray-800 transition">
                    Kontakt aufnehmen
                </a>
            </section>
        </div>
    </div>
@endsection
