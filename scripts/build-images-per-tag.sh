#!/usr/bin/env bash
set -euo pipefail

IMAGE_NAME="ghcr.io/marieme0610/gestion_reservation_universite"

TAGS=$(git tag -l --sort=v:refname)

for TAG in $TAGS; do
    echo "=== Traitement du tag $TAG ==="

    if ! git show "$TAG:Dockerfile" > /dev/null 2>&1; then
        echo "  -> Pas de Dockerfile à ce tag, on ignore."
        continue
    fi

    WORKTREE_DIR=$(mktemp -d)
    git worktree add --detach "$WORKTREE_DIR" "$TAG" > /dev/null

    echo "  -> Construction de l'image..."
    docker build -t "${IMAGE_NAME}:${TAG}" "$WORKTREE_DIR"

    echo "  -> Publication sur GHCR..."
    docker push "${IMAGE_NAME}:${TAG}"

    git worktree remove --force "$WORKTREE_DIR"
    echo "  -> Terminé pour $TAG"
done

echo "Tous les tags ont été traités."
