@extends('layouts.public')

@section('title', 'EDV Integration Dr. Setz - Home')

@section('content')
    <div class="prose prose-gray max-w-none">
        <!--
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Willkommen bei EDV Integration Dr. Setz</h1>
        -->

        <div class="text-gray-700 space-y-4">
            <p class="text-lg text-center">
		Senior DevOps Architect mit 30 Jahren Erfahrung in hochverfügbaren verteilten Systemen und Cloud-Infrastruktur.
            </p>



            <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Kernkompetenzen</h2>

            <div class="grid md:grid-cols-2 gap-6 my-6">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">IT-Beratung & Implementierung</h3>
                    <ul class="list-disc list-inside space-y-1 text-gray-700">
                        <liCloud Architecture & Migration ></li>
                        <li>DevOps Engineering & CI/CD</li>
                        <li>Python Development & Automation</li>
                        <li>Infrastructure as Code </li>
                        <li>Test-Driven Development & Quality Assurance</li>
                        <li>KI unterstütze Entwicklung</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Technische Schwerpunkte</h3>
                    <ul class="list-disc list-inside space-y-1 text-gray-700">
                       
                        <li>Migration von Anwendungen nach AWS</li>
                        <li>Aufbau von CI/CD-Pipelines und Testautomatisierung</li>
                        <li>Design hochverfügbarer Systeme</li>
                        <li>Skalierungsanalyse & Optimierung</li>
                        <li>DevOps-Beratung und Coaching</li>
                        <li>KI-Entwicklung und Coaching</li>
                    </ul>
                </div>
            </div>

<!--
            <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Leistungen</h2>
-->
            <div class="space-y-2">
                <div class="flex items-start">
                    <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3"></span>
                    <span>Technologie Stack</span>
                </div>
                <div class="flex items-start">
                    <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3"> </span>
                    <span><strong>Cloud:</strong> AWS (CDK, Lambda, CloudFormation, EC2, S3, IAM, KMS)</span>
                    <span><strong>DevOps:</strong> Docker, Ansible, Jenkins, GitLab CI/CD, GitHub Actions</span>
                     <br>
                    <span><strong>Entwicklung:</strong> Python, java, C Bash, SQL, REST </span>
                    <span><strong>Testing:</strong> pytest, Robot Framework, TDD</span>
                    <span><strong>KI Entwicklung:</strong> Claude, Gemini, Ollama</span>
                </div>
            </div>
        </div>

        @include('components.certifications')

        <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Interesse an einer Zusammenarbeit?</h3>
            <p class="text-gray-700 mb-4">
                Kontaktieren Sie uns für ein unverbindliches Gespräch über Ihre IT-Herausforderungen.
            </p>
            <a href="{{ route('contact') }}" class="inline-block px-6 py-2 bg-gray-900 text-white rounded hover:bg-gray-800 transition">
                Kontakt aufnehmen
            </a>
        </div>
    </div>
@endsection
