<?php

namespace App\DataFixtures;

use App\Entity\Formation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FormationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $formations = [
            ['titre' => 'Développement Web Full Stack', 'organisme' => 'TechAcademy Dijon', 'departement' => '21', 'ville' => 'Dijon', 'modalite' => 'hybride', 'lat' => 47.322047, 'lon' => 5.04148],
            ['titre' => 'Formation React Avancé', 'organisme' => 'CodeSchool Besançon', 'departement' => '25', 'ville' => 'Besançon', 'modalite' => 'presentiel', 'lat' => 47.237829, 'lon' => 6.024053],
            ['titre' => 'Java Spring Boot Masterclass', 'organisme' => 'DevInstitute Chalon', 'departement' => '71', 'ville' => 'Chalon-sur-Saône', 'modalite' => 'distanciel', 'lat' => 46.780768, 'lon' => 4.853895],
            ['titre' => 'Python Data Science', 'organisme' => 'DataLab Dijon', 'departement' => '21', 'ville' => 'Dijon', 'modalite' => 'presentiel', 'lat' => 47.322047, 'lon' => 5.04148],
            ['titre' => 'DevOps et Cloud AWS', 'organisme' => 'CloudTech Auxerre', 'departement' => '89', 'ville' => 'Auxerre', 'modalite' => 'hybride', 'lat' => 47.795889, 'lon' => 3.573781],
            ['titre' => 'Angular et TypeScript', 'organisme' => 'WebMasters Lons', 'departement' => '39', 'ville' => 'Lons-le-Saunier', 'modalite' => 'presentiel', 'lat' => 46.674379, 'lon' => 5.550379],
            ['titre' => 'Symfony 7 Expert', 'organisme' => 'PHPAcademy Mâcon', 'departement' => '71', 'ville' => 'Mâcon', 'modalite' => 'distanciel', 'lat' => 46.306884, 'lon' => 4.831731],
            ['titre' => 'Machine Learning avec Python', 'organisme' => 'AI Institute Nevers', 'departement' => '58', 'ville' => 'Nevers', 'modalite' => 'hybride', 'lat' => 46.990896, 'lon' => 3.162845],
            ['titre' => 'Docker et Kubernetes', 'organisme' => 'ContainerPro Vesoul', 'departement' => '70', 'ville' => 'Vesoul', 'modalite' => 'presentiel', 'lat' => 47.619788, 'lon' => 6.15428],
            ['titre' => 'Vue.js 3 Intensif', 'organisme' => 'VueMasters Dijon', 'departement' => '21', 'ville' => 'Dijon', 'modalite' => 'presentiel', 'lat' => 47.322047, 'lon' => 5.04148],
            ['titre' => 'Node.js Backend Development', 'organisme' => 'JSAcademy Beaune', 'departement' => '21', 'ville' => 'Beaune', 'modalite' => 'hybride', 'lat' => 47.024207, 'lon' => 4.839655],
            ['titre' => 'Formation Git et GitHub', 'organisme' => 'VersionControl Pro', 'departement' => '71', 'ville' => 'Autun', 'modalite' => 'distanciel', 'lat' => 46.951042, 'lon' => 4.299011],
            ['titre' => 'PostgreSQL Administration', 'organisme' => 'DatabaseExperts Sens', 'departement' => '89', 'ville' => 'Sens', 'modalite' => 'presentiel', 'lat' => 48.197424, 'lon' => 3.283663],
            ['titre' => 'Elasticsearch et Kibana', 'organisme' => 'SearchTech Dole', 'departement' => '39', 'ville' => 'Dole', 'modalite' => 'hybride', 'lat' => 47.092274, 'lon' => 5.489648],
            ['titre' => 'Microservices Architecture', 'organisme' => 'ArchitectPro Montbéliard', 'departement' => '25', 'ville' => 'Montbéliard', 'modalite' => 'distanciel', 'lat' => 47.510356, 'lon' => 6.798466],
            ['titre' => 'Laravel Framework', 'organisme' => 'PHPExperts Pontarlier', 'departement' => '25', 'ville' => 'Pontarlier', 'modalite' => 'presentiel', 'lat' => 46.903698, 'lon' => 6.354458],
            ['titre' => 'Flutter Mobile Development', 'organisme' => 'MobileAcademy Gray', 'departement' => '70', 'ville' => 'Gray', 'modalite' => 'hybride', 'lat' => 47.445505, 'lon' => 5.591797],
            ['titre' => 'GraphQL API Design', 'organisme' => 'APISchool Clamecy', 'departement' => '58', 'ville' => 'Clamecy', 'modalite' => 'distanciel', 'lat' => 47.460211, 'lon' => 3.519867],
            ['titre' => 'Rust Programming', 'organisme' => 'SystemProg Tonnerre', 'departement' => '89', 'ville' => 'Tonnerre', 'modalite' => 'presentiel', 'lat' => 47.856783, 'lon' => 3.973764],
            ['titre' => 'Swift iOS Development', 'organisme' => 'AppleDevs Chenôve', 'departement' => '21', 'ville' => 'Chenôve', 'modalite' => 'hybride', 'lat' => 47.289563, 'lon' => 5.001439],
            ['titre' => 'MongoDB NoSQL', 'organisme' => 'NoSQLExperts Le Creusot', 'departement' => '71', 'ville' => 'Le Creusot', 'modalite' => 'presentiel', 'lat' => 46.800557, 'lon' => 4.426543],
            ['titre' => 'Redis Cache Management', 'organisme' => 'CachePro Arbois', 'departement' => '39', 'ville' => 'Arbois', 'modalite' => 'distanciel', 'lat' => 46.902588, 'lon' => 5.774242],
            ['titre' => 'Jenkins CI/CD', 'organisme' => 'DevOpsSchool Belfort', 'departement' => '90', 'ville' => 'Belfort', 'modalite' => 'hybride', 'lat' => 47.639674, 'lon' => 6.863849],
            ['titre' => 'Terraform Infrastructure', 'organisme' => 'InfraTech Cosne', 'departement' => '58', 'ville' => 'Cosne-sur-Loire', 'modalite' => 'presentiel', 'lat' => 47.411574, 'lon' => 2.925913],
            ['titre' => 'Golang Backend', 'organisme' => 'GoExperts Luxeuil', 'departement' => '70', 'ville' => 'Luxeuil-les-Bains', 'modalite' => 'distanciel', 'lat' => 47.816344, 'lon' => 6.381748],
            ['titre' => 'Next.js SSR/SSG', 'organisme' => 'NextAcademy Avallon', 'departement' => '89', 'ville' => 'Avallon', 'modalite' => 'hybride', 'lat' => 47.490181, 'lon' => 3.908172],
            ['titre' => 'Kafka Streaming', 'organisme' => 'StreamTech Champagnole', 'departement' => '39', 'ville' => 'Champagnole', 'modalite' => 'presentiel', 'lat' => 46.748089, 'lon' => 5.907829],
            ['titre' => 'Prometheus Monitoring', 'organisme' => 'MonitorPro Quetigny', 'departement' => '21', 'ville' => 'Quetigny', 'modalite' => 'distanciel', 'lat' => 47.311344, 'lon' => 5.094589],
            ['titre' => 'Cypress E2E Testing', 'organisme' => 'TestAcademy Paray', 'departement' => '71', 'ville' => 'Paray-le-Monial', 'modalite' => 'hybride', 'lat' => 46.451383, 'lon' => 4.118343],
            ['titre' => 'RabbitMQ Messaging', 'organisme' => 'MessageQueue Pro', 'departement' => '25', 'ville' => 'Valdahon', 'modalite' => 'presentiel', 'lat' => 47.149752, 'lon' => 6.344539],
            ['titre' => 'Tailwind CSS Mastery', 'organisme' => 'CSSExperts Château-Chinon', 'departement' => '58', 'ville' => 'Château-Chinon', 'modalite' => 'distanciel', 'lat' => 47.065456, 'lon' => 3.933636],
            ['titre' => 'Nuxt.js Development', 'organisme' => 'NuxtSchool Lure', 'departement' => '70', 'ville' => 'Lure', 'modalite' => 'hybride', 'lat' => 47.683653, 'lon' => 6.496296],
            ['titre' => 'Svelte Framework', 'organisme' => 'SvelteAcademy Joigny', 'departement' => '89', 'ville' => 'Joigny', 'modalite' => 'presentiel', 'lat' => 47.982223, 'lon' => 3.397103],
            ['titre' => 'Nest.js Backend', 'organisme' => 'NestExperts Poligny', 'departement' => '39', 'ville' => 'Poligny', 'modalite' => 'distanciel', 'lat' => 46.836287, 'lon' => 5.707678],
            ['titre' => 'Deno Runtime', 'organisme' => 'DenoSchool Talant', 'departement' => '21', 'ville' => 'Talant', 'modalite' => 'hybride', 'lat' => 47.336551, 'lon' => 4.990891],
            ['titre' => 'Playwright Testing', 'organisme' => 'E2ETest Tournus', 'departement' => '71', 'ville' => 'Tournus', 'modalite' => 'presentiel', 'lat' => 46.558757, 'lon' => 4.909425],
            ['titre' => 'Vite.js Build Tool', 'organisme' => 'BuildTech Morteau', 'departement' => '25', 'ville' => 'Morteau', 'modalite' => 'distanciel', 'lat' => 47.056526, 'lon' => 6.606571],
            ['titre' => 'Webpack Configuration', 'organisme' => 'BundlerPro Decize', 'departement' => '58', 'ville' => 'Decize', 'modalite' => 'hybride', 'lat' => 46.827877, 'lon' => 3.461291],
            ['titre' => 'Astro Static Sites', 'organisme' => 'StaticSite Academy', 'departement' => '70', 'ville' => 'Héricourt', 'modalite' => 'presentiel', 'lat' => 47.574901, 'lon' => 6.758935],
            ['titre' => 'Remix Framework', 'organisme' => 'RemixExperts Migennes', 'departement' => '89', 'ville' => 'Migennes', 'modalite' => 'distanciel', 'lat' => 47.965858, 'lon' => 3.516214],
            ['titre' => 'SolidJS Reactive', 'organisme' => 'SolidSchool Saint-Claude', 'departement' => '39', 'ville' => 'Saint-Claude', 'modalite' => 'hybride', 'lat' => 46.387125, 'lon' => 5.863779],
            ['titre' => 'Qwik Framework', 'organisme' => 'QwikAcademy Fontaine', 'departement' => '21', 'ville' => 'Fontaine-lès-Dijon', 'modalite' => 'presentiel', 'lat' => 47.343164, 'lon' => 5.020587],
            ['titre' => 'Bun JavaScript Runtime', 'organisme' => 'BunExperts Louhans', 'departement' => '71', 'ville' => 'Louhans', 'modalite' => 'distanciel', 'lat' => 46.629446, 'lon' => 5.224056],
            ['titre' => 'Pinia State Management', 'organisme' => 'StateManagement Pro', 'departement' => '25', 'ville' => 'Maîche', 'modalite' => 'hybride', 'lat' => 47.251811, 'lon' => 6.801441],
            ['titre' => 'Zustand React State', 'organisme' => 'ReactState La Charité', 'departement' => '58', 'ville' => 'La Charité-sur-Loire', 'modalite' => 'presentiel', 'lat' => 47.177516, 'lon' => 3.018497],
            ['titre' => 'MobX State Tree', 'organisme' => 'MobXSchool Ronchamp', 'departement' => '70', 'ville' => 'Ronchamp', 'modalite' => 'distanciel', 'lat' => 47.700352, 'lon' => 6.633983],
            ['titre' => 'Recoil State Management', 'organisme' => 'RecoilAcademy Villeneuve', 'departement' => '89', 'ville' => 'Villeneuve-sur-Yonne', 'modalite' => 'hybride', 'lat' => 48.080524, 'lon' => 3.285858],
            ['titre' => 'Jotai Atomic State', 'organisme' => 'AtomicState Morez', 'departement' => '39', 'ville' => 'Morez', 'modalite' => 'presentiel', 'lat' => 46.520551, 'lon' => 6.023299],
            ['titre' => 'TanStack Query', 'organisme' => 'QueryExperts Nuits', 'departement' => '21', 'ville' => 'Nuits-Saint-Georges', 'modalite' => 'distanciel', 'lat' => 47.136896, 'lon' => 4.949552],
            ['titre' => 'RTK Query', 'organisme' => 'ReduxSchool Cluny', 'departement' => '71', 'ville' => 'Cluny', 'modalite' => 'hybride', 'lat' => 46.434124, 'lon' => 4.659035],
            ['titre' => 'SWR Data Fetching', 'organisme' => 'DataFetch Audincourt', 'departement' => '25', 'ville' => 'Audincourt', 'modalite' => 'presentiel', 'lat' => 47.481815, 'lon' => 6.842766],
            ['titre' => 'Formik Forms', 'organisme' => 'FormsPro Imphy', 'departement' => '58', 'ville' => 'Imphy', 'modalite' => 'distanciel', 'lat' => 46.930309, 'lon' => 3.259879],
            ['titre' => 'React Hook Form', 'organisme' => 'HookForm Academy', 'departement' => '70', 'ville' => 'Saint-Loup-sur-Semouse', 'modalite' => 'hybride', 'lat' => 47.884296, 'lon' => 6.273947],
            ['titre' => 'Yup Validation', 'organisme' => 'ValidationExperts Saint-Florentin', 'departement' => '89', 'ville' => 'Saint-Florentin', 'modalite' => 'presentiel', 'lat' => 48.001236, 'lon' => 3.726839],
            ['titre' => 'Zod Schema Validation', 'organisme' => 'SchemaSchool Salins', 'departement' => '39', 'ville' => 'Salins-les-Bains', 'modalite' => 'distanciel', 'lat' => 46.939475, 'lon' => 5.878963],
            ['titre' => 'Vitest Testing', 'organisme' => 'TestAcademy Longvic', 'departement' => '21', 'ville' => 'Longvic', 'modalite' => 'hybride', 'lat' => 47.287665, 'lon' => 5.063554],
            ['titre' => 'Jest Testing Framework', 'organisme' => 'JestExperts Montchanin', 'departement' => '71', 'ville' => 'Montchanin', 'modalite' => 'presentiel', 'lat' => 46.749901, 'lon' => 4.469839],
            ['titre' => 'Testing Library', 'organisme' => 'TestingLib Baume', 'departement' => '25', 'ville' => 'Baume-les-Dames', 'modalite' => 'distanciel', 'lat' => 47.352411, 'lon' => 6.360632],
            ['titre' => 'MSW API Mocking', 'organisme' => 'MockAPI Fourchambault', 'departement' => '58', 'ville' => 'Fourchambault', 'modalite' => 'hybride', 'lat' => 47.017632, 'lon' => 3.080943]
        ];

        foreach ($formations as $data) {
            $formation = new Formation();
            $formation->setTitre($data['titre'])
                ->setOrganisme($data['organisme'])
                ->setDepartement($data['departement'])
                ->setVille($data['ville'])
                ->setModalite($data['modalite']);

            if (isset($data['lat']) && isset($data['lon'])) {
                $formation->setLatitude($data['lat'])
                    ->setLongitude($data['lon']);
            }

            $startDate = new \DateTime();
            $startDate->add(new \DateInterval('P' . rand(1, 60) . 'D'));
            $formation->setDateDebut($startDate);

            $endDate = clone $startDate;
            $endDate->add(new \DateInterval('P' . rand(5, 30) . 'D'));
            $formation->setDateFin($endDate);

            if (rand(0, 10) > 3) {
                $formation->setUrl('https://example.com/formation/' . uniqid());
            }

            $manager->persist($formation);
        }

        $manager->flush();
    }
}