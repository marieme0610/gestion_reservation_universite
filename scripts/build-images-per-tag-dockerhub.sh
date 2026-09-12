#!/usr/bin/env bash
set -uo pipefail
IMAGE_NAME="marieme0610/gestion-reservation"

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

    e    echo "  -> Publication sur Docker Hub..."
    for essai in 1 2 3; do
        if docker push "${IMAGE_NAME}:${TAG}"; then
            break
        fi
        echo "  -> Échec, nouvelle tentative ($essai/3)..."
        sleep 5
    done

    git worktree remove --force "$WORKTREE_DIR"
    echo "  -> Terminé pour $TAG"
done

echo "Tous les tags ont été traités."