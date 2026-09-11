<?php

namespace App\Repository;

use App\Repository\SalleRepositoryInterface;
use App\Model\Salle;
use App\Support\PaginationResult;
use App\Repository\Filtre\SalleFiltreInterface;

class SalleRepository implements SalleRepositoryInterface
{

    public function __construct(private array $filtres) {}

   public function getAllSalle(): array
   {
      return Salle::all()->all();
   }
   public function findSalle(int $id): ?Salle
   {
      return Salle::find($id);
   }
   public function saveSalle(Salle $salle): int
   {
      $salle->save();
      return (int)$salle->id;
   }


   public function rechercherEtPaginer(array $criteres, int $page, int $parPage): PaginationResult
   {
        $query = Salle::query();

        foreach ($this->filtres as $filtre) {
            if ($filtre->estActif($criteres)) {
                $filtre->appliquerSurRequete($query, $criteres);
            }
        }

                $paginator = $query->orderBy('nom')
            ->paginate(perPage: $parPage, page: max(1, $page));

        return PaginationResult::depuisEloquent($paginator);
   }

}
