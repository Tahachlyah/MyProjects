<?php
 
namespace App\Services;
 
use Symfony\Component\Form\FormInterface;
 
class ImageManager
{
 
    const UPLOAD_DIR_IMAGE = 'images';
 
    /**
     * Fonction pour enregistrer une image
     *
     * @param FormInterface $form le formulaire
     * @param string $fields le nom de la colonne ou propriété de la class
     * @param Object $table la table sur laquelle on veut enregistrer l'image
     * @param string $imageDefault si new sans image j'enregistre l'image par défaut, si edit je récupère l'ancien nom
     * @return void
     */
    public function EnregistreImage(FormInterface $form, $fields, Object $table, $imageDefault)
    {
        $image = $form->get($fields)->getData();
        $methode = 'set' . ucfirst($fields);
        if ($image) {
            $new_name_image = uniqid() . '.' . $image->guessExtension();
            $image->move(self::UPLOAD_DIR_IMAGE, $new_name_image);
            $table->setImage($new_name_image);
        } else {
            $table->setImage($imageDefault);
        }
    }
}
 
