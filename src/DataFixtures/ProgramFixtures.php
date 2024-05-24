<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [

        // Action

        ['title' => 'Alias',
        'synopsis' => "Sydney Bristow travaille comme espionne pour une branche secrète de la CIA, appelée SD 6. C'est du moins ce qu'elle croit, jusqu'au jour où le chef de son unité, Arvin Sloane, fait assassiner son fiancé, après qu'elle lui a avoué sa double vie. Elle se rend alors à la vraie CIA et devient agent double, pour détruire cette organisation terroriste. Aux côtés de son père et de son agent de liaison, Michael Vaughn, elle combat le SD 6 et Arvin Sloane dans sa quête des artefacts de Rambaldi...",
        'category' => 'category_Action',],
        ['title' => 'Le Caméléon',
        'synopsis' => "Un jeune homme sort de son mutisme. Il dit s'appeler Nicholas Mark Randall, être américain et avoir été enlevé quatre ans plus tôt par les membres d'une secte.",
        'category' => 'category_Action',],
        ['title' => '24 Heures Chrono',
        'synopsis' => "La série relate en temps réel les journées de membres d'une agence fictive, la Cellule anti-terroriste (Counter Terrorist Unit en version originale), luttant contre diverses attaques terroristes aux États-Unis. Le personnage principal, Jack Bauer, est chargé de poursuivre les terroristes et de remonter les réseaux souvent aidés par des « taupes » au sein des services spéciaux ou de l’administration.",
        'category' => 'category_Action',],
        ['title' => "L'Agence tous risques",
        'synopsis' => "Un groupe de quatre anciens soldats d'un commando d'élite sont recherchés par l'armée après s'être évadés de prison, alors qu'ils avaient été condamnés à tort. Hannibal aime diriger les opérations, Futé est souvent à l'origine des plans de génie.",
        'category' => 'category_Action',],
        ['title' => "The Sentinel",
        'synopsis' => "Après un séjour dans la jungle du Pérou en tant que commando de l'US Army, Jim Ellison se retrouve doté de sens hyper-développés. Il met à profit cette particularité dans son travail de policier à Cascade, ville imaginaire située dans l'État de Washington. Il fait la connaissance de Blair Sandburg, un étudiant en anthropologie (à la Rainier University) qui l'aide à contrôler ses sens, et se lie d'amitié avec lui. Il travaille sous les ordres du capitaine Simon Banks.",
        'category' => 'category_Action',],

        // Aventure

        ['title' => "Sydney Fox, l'aventurière",
        'synopsis' => "Sydney Bristow travaille comme espionne pour une branche secrète de la CIA, appelée SD 6. C'est du moins ce qu'elle croit, jusqu'au jour où le chef de son unité, Arvin Sloane, fait assassiner son fiancé, après qu'elle lui a avoué sa double vie. Elle se rend alors à la vraie CIA et devient agent double, pour détruire cette organisation terroriste. Aux côtés de son père et de son agent de liaison, Michael Vaughn, elle combat le SD 6 et Arvin Sloane dans sa quête des artefacts de Rambaldi...",
        'category' => 'category_Aventure',],
        ['title' => 'The Last of Us',
        'synopsis' => "Pour Joel, la survie est une préoccupation quotidienne qu'il gère à sa manière. Mais quand son chemin croise celui d'Ellie, leur voyage à travers ce qui reste des États-Unis va mettre à rude épreuve leur humanité et leur volonté de survivre.",
        'category' => 'category_Aventure',],
        ['title' => 'Blood & Treasure',
        'synopsis' => "Danny McNamara, un brillant expert en antiquités, et Lexi Vaziri, une voleuse d'art rusée, font équipe pour attraper Karim Farouk, un terroriste impitoyable qui finance ses attaques grâce à des trésors volés.",
        'category' => 'category_Aventure',],
        ['title' => "Doctor Who",
        'synopsis' => "Doctor Who relate les aventures de son personnage principal, un extraterrestre originaire de Gallifrey, se présentant comme un Seigneur du Temps, appelé le Docteur.",
        'category' => 'category_Aventure',],
        ['title' => "Lost : Les Disparus",
        'synopsis' => "Après le crash de leur avion sur une île perdue, des survivants doivent apprendre à cohabiter et survivre dans cet environnement hostile. Bien vite, ils se rendent compte qu'une menace semble planer sur l'île.",
        'category' => 'category_Aventure',],

        // Animation

        ['title' => "Fairy Tail",
        'synopsis' => "L’histoire se focalise principalement sur les missions effectuées par l’une des équipes de la guilde Fairy Tail, composée de Natsu Dragnir (chasseur de dragon de feu), Lucy Heartfilia (constellationniste) et Happy (un Exceed, chat bleu pouvant se faire apparaître des ailes, voler et parler), qui seront très vite rejoints par Erza Scarlett (mage chevalier) et Grey Fullbuster (mage de glace), deux autres membres de la fameuse guilde. Ils sont rejoints au cours de l'aventure par Carla (une chatte blanche Exceed, comme Happy), Wendy (chasseuse de dragon céleste), et par bien d'autres.",
        'category' => 'category_Animation',],
        ['title' => "Les mystérieuses cités d'or",
        'synopsis' => "Esteban, un jeune orphelin âgé d'une douzaine d'années, et Zia, une jeune fille Inca, partent vers le Nouveau Monde à la recherche des légendaires Cités d'or.",
        'category' => 'category_Animation',],
        ['title' => 'Papyrus',
        'synopsis' => "Papyrus, simple pêcheur et Théti, Princesse d'Égypte vivent au temps des pharaons.",
        'category' => 'category_Animation',],
        ['title' => "Totally Spies !",
        'synopsis' => "Les aventures de trois amies adolescentes : Alex, Clover et Sam. Elles sont agents secrets, des espionnes professionnelles qui travaillent pour le WOOHP, une organisation secrète de protection de l'humanité.",
        'category' => 'category_Animation',],
        ['title' => "Scooby-Doo",
        'synopsis' => "Dans cette nouvelle aventure, Velma, Fred, Daphné, Sammy et sans oublier Scooby-Doo, enquêtent sur la disparition d'un directeur de musée.",
        'category' => 'category_Animation',],

        
        // Fantastique

        ['title' => "Buffy contre les vampires",
        'synopsis' => "Buffy Summers (interprétée par Sarah Michelle Gellar) est une Tueuse de vampires issue d'une longue lignée d'Élues luttant contre les forces du mal, et notamment les vampires et les démons. À l'instar des précédentes Tueuses, elle bénéficie des enseignements de son Observateur, chargé de la guider et de l'entraîner.",
        'category' => 'category_Fantastique',],
        ['title' => "Fringe",
        'synopsis' => "L'agente spéciale du FBI Olivia Dunham fait partie du bureau de la Division Fringe, où elle enquête sur des crimes aux circonstances inhabituelles. Le Dr Walter Bishop, un scientifique autrefois interné, Peter, son fils touche-à-tout, et le jeune agent Astrid Farnsworth aident la jeune femme dans ses investigations. Alors que l'équipe enquête sur des phénomènes étranges et inexpliqués, chacun découvre des liens entre son propre passé et un univers parallèle. Et, à mesure que le groupe d'enquêteurs parvient à résoudre les cas dans ces deux mondes étroitement liés, de nouvelles découvertes et complications continuent de surgir.",
        'category' => 'category_Fantastique',],
        ['title' => 'Cursed : La Rebelle',
        'synopsis' => "Nimue, une adolescente dotée d'un mystérieux don, est destinée à devenir la Dame du Lac. Après la mort de sa mère, elle part à la recherche de Merlin et d'une ancienne épée, accompagnée du jeune mercenaire Arthur.",
        'category' => 'category_Fantastique',],
        ['title' => "Lockwood and Co",
        'synopsis' => "Une jeune fille dotée de capacités psychiques rejoint deux adolescents de l'agence de chasseurs de fantômes Lockwood & Co. pour combattre les phénomènes paranormaux à Londres et déjouer un complot diabolique.",
        'category' => 'category_Fantastique',],
        ['title' => "The Witcher : L'Héritage du sang",
        'synopsis' => "Sept parias du monde des elfes s'unissent dans une quête contre une puissance inarrêtable, la conjonction des sphères, où les mondes des monstres, des hommes et des elfes ont fusionné pour ne faire plus qu'un.",
        'category' => 'category_Fantastique',],

        // Horreur

        ['title' => "American Horror Story",
        'synopsis' => "American Horror Story, ou Histoire d'horreur au Québec, est une anthologie télévisée américaine créée et produite par Ryan Murphy et Brad Falchuk, diffusée depuis le 5 octobre 2011 sur la chaîne FX et disponible le lendemain sur le service de streaming Hulu et au Canada depuis le 31 octobre 2011 sur FX Canada.",
        'category' => 'category_Horreur',],
        ['title' => "Hannibal",
        'synopsis' => "Jack Crawford recrute un profiler qui possède un don lui permettant d'aider à la capture de tueurs.",
        'category' => 'category_Horreur',],
        ['title' => 'The Walking Dead',
        'synopsis' => "Après une apocalypse ayant transformé la quasi-totalité de la population en zombies, un groupe d'hommes et de femmes mené par l'officier Rick Grimes tente de survivre. Ensemble, ils vont devoir tant bien que mal faire face à ce nouveau monde.",
        'category' => 'category_Horreur',],
        ['title' => "Stranger Things",
        'synopsis' => "En 1983, à Hawkins dans l'Indiana, Will Byers disparaît de son domicile. Ses amis se lancent alors dans une recherche semée d'embûches pour le retrouver. Pendant leur quête de réponses, les garçons rencontrent une étrange jeune fille en fuite.",
        'category' => 'category_Horreur',],
        ['title' => "The Purge",
        'synopsis' => "Pendant 12 heures, tous les crimes, y compris les meurtres, sont légaux. Un groupe de personnes apparemment sans lien se croisent dans une réalité altérée des États-Unis. Alors que le temps passe, certains vont se battre, certains vont se cacher.",
        'category' => 'category_Horreur',],
    ];

    public function load(ObjectManager $manager): void
    {
       
        foreach (self::PROGRAMS as $programName){

        $program = new Program();
        $program->setTitle($programName['title']);
        $program->setSynopsis($programName['synopsis']);
        $program->setCategory($this->getReference($programName['category']));
        $manager->persist($program);

        }
      
        $manager->flush();

    }
    public function getDependencies()
    {
        //Tu retournes ici toutes les classe de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }
}
