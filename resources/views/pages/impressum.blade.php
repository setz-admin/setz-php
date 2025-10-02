@extends('layouts.public')

@section('title', 'Impressum - EDV Integration Dr. Setz')

@section('content')
    <div class="prose prose-gray max-w-none">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Impressum</h1>

        <div class="text-gray-700 space-y-6">
            <section>
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Angaben gemäß § 5 TMG</h2>
                <div class="bg-white border border-gray-200 rounded p-6">
                    <p class="font-semibold">EDV-Integration Dr Setz</p>
                    <p>
                        Weierbacherstr. 65 a<br>
                        55743 Idar-Oberstein<br>
                        Deutschland
                    </p>
                </div>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Vertreten durch</h2>
                <div class="bg-white border border-gray-200 rounded p-6">
                    <p>Dr.-Ing. Thomas Setz</p>
                </div>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Kontakt</h2>
                <div class="bg-white border border-gray-200 rounded p-6">
                    <p>
                        E-Mail: <a href="mailto:info@setz.de" class="text-blue-600 hover:text-blue-800">info@setz.de</a><br>
                        Web: <a href="https://www.setz.de" class="text-blue-600 hover:text-blue-800">www.setz.de</a>
                    </p>
                </div>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Umsatzsteuer-ID</h2>
                <div class="bg-white border border-gray-200 rounded p-6">
                    <p>
                        Umsatzsteuer-Identifikationsnummer gemäß § 27 a Umsatzsteuergesetz:<br>
                        <span class="font-mono">DE 191198967</span>
                    </p>
                </div>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h2>
                <div class="bg-white border border-gray-200 rounded p-6">
                    <p>
                        Dr.-Ing. Thomas Setz<br>
                        Weierbacherstr. 65 a<br>
                        55743 Idar-Oberstein<br>
                        Deutschland
                    </p>
                </div>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Haftungsausschluss</h2>

                <div class="space-y-4">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Haftung für Inhalte</h3>
                        <p class="text-sm">
                            Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den
                            allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht
                            verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen
                            zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen.
                        </p>
                        <p class="text-sm mt-2">
                            Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen
                            Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der
                            Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden
                            Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Haftung für Links</h3>
                        <p class="text-sm">
                            Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben.
                            Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der
                            verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten
                            Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft. Rechtswidrige
                            Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar.
                        </p>
                        <p class="text-sm mt-2">
                            Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer
                            Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links
                            umgehend entfernen.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Urheberrecht</h3>
                        <p class="text-sm">
                            Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen
                            Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der
                            Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers.
                            Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet.
                        </p>
                        <p class="text-sm mt-2">
                            Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter
                            beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine
                            Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei
                            Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.
                        </p>
                    </div>
                </div>
            </section>

            <section class="mt-8 p-6 bg-gray-50 border border-gray-200 rounded">
                <p class="text-sm text-gray-600">
                    Stand: {{ date('d.m.Y') }}
                </p>
            </section>
        </div>
    </div>
@endsection
