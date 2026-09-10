# Scripts utilitaires

## build-images-per-tag.sh

Reconstruit et publie une image Docker sur GHCR pour chaque tag Git du dépôt
qui possède un `Dockerfile` (donc à partir de v1.3.0). Les tags antérieurs
sont ignorés silencieusement (l'application n'était pas encore conteneurisée).

Usage :
```bash
gh auth token | docker login ghcr.io -u <ton-user> --password-stdin
./scripts/build-images-per-tag.sh
```

Note : pour les tags futurs, ce script n'est normalement plus nécessaire —
le workflow `.github/workflows/docker-publish.yml` s'en charge automatiquement
à chaque `git push origin vX.Y.Z`. Il reste utile pour reconstruire un ancien
tag après coup si besoin.
