<?php

namespace App\Controller;

use App\Entity\ImportCsv;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImportCsvController extends AbstractController
{

    /**
     * @Route("/import/csv", name="import_csv")
     */
    function upload(Request $request, ObjectManager $em)
    {
        $repo = $this->getDoctrine()->getRepository(ImportCsv::class);
        $import_csv = $repo->findAll();

        $form2 = $this->createFormBuilder()
            ->add('submitFile', FileType::class, ['label' => 'choisir un fichier'])
            ->getForm();
        // Form creation ommited
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            /** @var UploadedFile */
            $file = $form2->get('submitFile')->getData();

            // Open the file

            if (($handle = fopen($file->getPathname(), "r")) !== false) {
                // Read and process the lines. 
                // Skip the first line if the file includes a header
                fgetcsv($handle);
                
                while (($data = fgetcsv($handle, 1000, ";")) !== false) {



                    // Do the processing: Map line to entity, validate if needed

                    $importCsv = new ImportCsv();
                    // Assign fields
                    $importCsv->setLastName($data[0]);
                    $importCsv->setFirstName($data[1]);
                    $importCsv->setToNumber($data[2]);
                    $importCsv->setBorn(\DateTime::createFromFormat('Y-m-d', $data[3]));
                    $importCsv->setSubCategory($data[4]);
                    $importCsv->setSex($data[5]);
                    $importCsv->setComplement($data[6]);
                    $importCsv->setAddress($data[7]);
                    $importCsv->setPostalCode($data[8]);
                    $importCsv->setCity($data[9]);
                    $importCsv->setRecord(\DateTime::createFromFormat('Y-m-d', $data[10]));
                    $importCsv->setHomePhone($data[11]);
                    $importCsv->setMobilePhone($data[12]);
                    $importCsv->setEmail($data[13]);
                    $importCsv->setPlaceOfBirth($data[14]);
                    $importCsv->setClubChange($data[15]);
                    $importCsv->setClubOut($data[16]);



                    $em->persist($importCsv);
                }
                fclose($handle);
                $em->flush();
            }
            $this->addFlash(
                'success',
                "Le fichier a bien été importé"
            );
            return $this->redirectToRoute('import_csv');
        }
        return $this->render('import_csv/index.html.twig', [
            'form2' => $form2->createView(),
            'import_csv' => $import_csv,
        ]);
    }


    /**
     * @Route("import/insert", name="import_insert")
     */
    public function import_insert(Connection $connection): Response
    {

        $connection->exec('INSERT INTO adherent
    (last_name,first_name,to_number,born,sub_category,sex,complement,address,postal_code,city,record,home_phone,mobile_phone,email,place_of_birth,club_change,club_out)
      
    SELECT
    import_csv.last_name,import_csv.first_name,import_csv.to_number,import_csv.born,import_csv.sub_category,import_csv.sex,import_csv.complement,import_csv.address,import_csv.postal_code,import_csv.city,import_csv.record,import_csv.home_phone,import_csv.mobile_phone,import_csv.email,import_csv.place_of_birth,import_csv.club_change,import_csv.club_out
    FROM import_csv LEFT JOIN adherent ON import_csv.to_number=adherent.to_number
    WHERE adherent.to_number IS NULL');
        $this->addFlash(
            'success',
            "L'insertion des nouveaux adhérent a été réalisé avec succés!"
        );

        return $this->redirectToRoute('import_csv');
    }
    /**
     * @Route("import/update", name="import_update")
     */
    public function import_update(Connection $connection): Response
    {

        $connection->exec('UPDATE adherent as a
        INNER JOIN import_csv as i ON i.to_number = a.to_number
        SET
        a.last_name=i.last_name,
        a.first_name=i.first_name,
        a.to_number=i.to_number,
        a.born=i.born,
        a.sub_category=i.sub_category,
        a.sex=i.sex,
        a.complement=i.complement,
        a.address=i.address,
        a.postal_code=i.postal_code,
        a.city=i.city,
        a.record=i.record,
        a.home_phone=i.home_phone,
        a.mobile_phone=i.mobile_phone,
        a.email=i.email,
        a.place_of_birth=i.place_of_birth,
        a.club_change=i.club_change,
        a.club_out=i.club_out'
       );

        $this->addFlash(
            'success',
            "Votre liste d'adhérent a été mise à jour!"
        );
        return $this->redirectToRoute('import_csv');
    }
    /**
     * Permet de suprimer le fichier import_csv
     * 
     * @Route("import_csv/delete", name="import_csv_delete")
     *
     * 
     */
    public function import_csv_delete()
    {
        $connection = $this->getDoctrine()->getConnection();
        $platform   = $connection->getDatabasePlatform();
        $connection->executeUpdate($platform->getTruncateTableSQL('import_csv', true /* whether to cascade */));

        $this->addFlash(
            'success',
            "Le fichier CSV a été supprimées !"
        );

        return $this->redirectToRoute('import_csv');
    }
}
