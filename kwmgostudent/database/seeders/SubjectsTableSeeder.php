<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $subject = new Subject;
            $subject->lva = 'lva' . rand(100, 999);
            $subject->name = 'Mathematik';
            $subject->description = "Mathematik umfasst viele verschiedene Bereiche. Vor allem Felder wie
            Trigonometrie, Wahrscheinlichkeitsrechnungen und allgemeine Zahlenlehre stehen hier im Vordergrund
            des Faches.";
            $subject->save();
        }
        {
            $subject = new Subject;
            $subject->lva = 'LVA'.rand(100, 999);
            $subject->name = 'Informatik';
            $subject->description = 'Dieses Fach deckt viele Themengebiete im Bereich Technik ab. Vor allem
            Programmiersprachen wie Java, Python oder C# werden behandelt. Auch Betriebssysteme wie Linux und
            Netzwerktechnik zählen zu den unterrichteten Fächern.';
            $subject->save();
        }
        {
            $subject = new Subject;
            $subject->lva = 'LVA'.rand(100, 999);
            $subject->name = 'Deutsch';
            $subject->description = 'Dieses Fach behandelt viele Grammatik- und Rechtschreibgrundlagen der
            Sprache Deutsch. Besonders werden auf die Eigenheiten der deutschen Sprache eingegangen.';
            $subject->save();
        }
        {
            $subject = new Subject;
            $subject->lva = 'LVA'.rand(100, 999);
            $subject->name = 'Biologie';
            $subject->description = "Unter Biologie fallen beispielsweise Humanbiologie, Botanik, Genetik oder
            allgemeine Evolutionsbiologie.";
            $subject->save();
        }
    }

}
