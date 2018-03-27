<?php


namespace App\Controller;

use App\DataView\InventoryItemView;
use App\Util\InventoryViewFactory;
use App\Util\ShowDataProviderForUs2;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventoryController extends Controller
{
    /**
     * @Route("/inventory/show/")
     * @param Request $request
     * @return Response
     */
    public function show(Request $request)
    {
        $inventoryItemArr = [];

        $form = $this->createFormBuilder()
            ->add('showDate', DateType::class, [
                'label' => 'Show date:',
                'data' => new \DateTime(), // defaults to now by server time
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'required' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Submit',
                'attr' => ['class' => 'form-control mx-2']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Lets get data
            $formData = $form->getData();
            $showDate = $formData['showDate'];

            $inventoryItemArr = $this->getInventoryItemArr($showDate);
        }

        return $this->render('inventory/show.html.twig', [
            'inventoryItemArr' => $inventoryItemArr,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param \DateTime $showDate
     * @return InventoryItemView[]
     */
    private function getInventoryItemArr(\DateTime $showDate): array
    {
        // Lets get data
        $queryDate = new \DateTime(); // Today
        $showDataProvider = ShowDataProviderForUs2::getDataProvider();
        $inventoryViewFactory = new InventoryViewFactory($showDataProvider);
        $inventoryView = $inventoryViewFactory->get($queryDate, $showDate);

        $inventoryItemArr = $inventoryView->getInventory();

        return $inventoryItemArr;
    }
}