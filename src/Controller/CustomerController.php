<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use ProxyManager\Factory\RemoteObject\Adapter\JsonRpc;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    #[Route(path: '/customer', name: 'create_customer', methods: ['POST'])]
    public function createCustomer(Request $request, CustomerRepository $customerRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $firstName = $data['first_name'];
        $lastName = $data['last_name'];
        $email = $data['email'];
        $phoneNumber = $data['phone_number'];

        if (empty($firstName) || empty($lastName) || empty($email) || empty($phoneNumber)) {
            throw new NotFoundHttpException('Missing required values');
        }

        $customerRepository->save(
            entity: new Customer(
                firstName: $firstName,
                lastName: $lastName,
                email: $email,
                phoneNumber: $phoneNumber
            ),
            flush: true
        );

        return new JsonResponse(['data' => ['created' => 'true']], Response::HTTP_CREATED);
    }

    #[Route(path: '/customer/{id}', name: 'get_customer', methods: ['GET'])]
    public function getCustomer(int $id, CustomerRepository $customerRepository): JsonResponse
    {
        $customer = $customerRepository->findOneBy(['id' => $id]);
        $data = [
            'id' => $customer->getId(),
            'first_name' => $customer->getFirstName(),
            'last_name' => $customer->getLastName(),
            'email' => $customer->getEmail(),
            'phone_number' => $customer->getPhoneNumber()
        ];

        return new JsonResponse(['data' => $data], Response::HTTP_OK);
    }

    #[Route(path: '/customer/{id}', name: 'update_customer', methods: ['PUT'])]
    public function updateCustomer(int $id, Request $request, CustomerRepository $customerRepository): JsonResponse
    {
        $customer = $customerRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['first_name']) ? true : $customer->setFirstName($data['first_name']);
        empty($data['last_name']) ? true : $customer->setLastName($data['last_name']);
        empty($data['email']) ? true : $customer->setEmail($data['email']);
        empty($data['phone_number']) ? true : $customer->setEmail($data['phone_number']);

        $updatedCustomer = $customerRepository->save(entity: $customer, flush: true);

        return new JsonResponse(['data' => $updatedCustomer->toArray()], Response::HTTP_OK);
    }

    #[Route(path: '/customer/{id}', name: 'delete_customer', methods: ['DELETE'])]
    public function delete(int $id, CustomerRepository $customerRepository): JsonResponse
    {
        $customer = $customerRepository->findOneBy(['id' => $id]);

        $customerRepository->remove(entity: $customer, flush: true);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
