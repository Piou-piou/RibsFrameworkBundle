<?php

namespace PiouPiou\RibsAdminBundle\Form;

use PiouPiou\RibsAdminBundle\Form\Type\UploaderType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class Version extends AbstractType
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
	    $version = isset($options["data"]) && $options["data"] ? $options["data"] : null;
	    $entity_name = null;
	    $entity_id = null;
	    $param_retrieve = null;

	    if ($version) {
	        $entity_id = $version->getId();
	        $entity_name = str_replace("\\", "\/", get_class($version));
            $param_retrieve = ',"entity_name": "'.$entity_name.'","entity_id": "'.$entity_id.'"';
        }

		$builder
			->add("packageConfig", TextType::class, [
				"label" => "Config file name"
			])
            ->add("packageConfigFile", UploaderType::class, [
                "uploader_name" => "config_file",
                "data_url_param" => '{"url":"'.$this->router->generate("ribsadmin_upload", ["folder" => "data/ribs-package"]).'"}',
                "data_retrieve_url_param" => '{"url":"'.$this->router->generate("ribsadmin_retrieve_uploaded_file", ["folder" => "data/ribs-package"]).'","field_name": "packageConfigFile"'.$param_retrieve.'}',
                "data_delete_url_param" => '{"url":"'.$this->router->generate("ribsadmin_delete_uploaded_file", ["folder" => "data/ribs-package"]).'"}',
                "accept" => "application/x-yaml"
            ])
            ->add("packageRoute", TextType::class, [
                "label" => "Config route name"
            ])
            ->add("packageRouteFile", UploaderType::class, [
                "uploader_name" => "route_file",
                "data_url_param" => '{"url":"'.$this->router->generate("ribsadmin_upload", ["folder" => "data/ribs-package"]).'"}',
                "data_retrieve_url_param" => '{"url":"'.$this->router->generate("ribsadmin_retrieve_uploaded_file", ["folder" => "data/ribs-package"]).'","field_name": "packageRouteFile"'.$param_retrieve.'}',
                "data_delete_url_param" => '{"url":"'.$this->router->generate("ribsadmin_delete_uploaded_file", ["folder" => "data/ribs-package"]).'"}',
                "accept" => "application/x-yaml"
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Validate',
                'attr' => []
            ]);
	}

    /**
     * @param OptionsResolver $resolver
     */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			"data_class" => \PiouPiou\RibsAdminBundle\Entity\Version::class,
		]);
	}
}
