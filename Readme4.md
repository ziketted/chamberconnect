Tu es un expert en Laravel, Tailwind, UI/UX Design system, Single Source of Truth et architecture propre.  
Ta mission est de créer / améliorer complètement le module "SuperAdmin" du projet Chambre (ChamberConnect DRC).

Respecte **absolument** la charte UX/UI existante du projet, les composants standards, les espacements, les couleurs, les layouts actuels, et l’identité visuelle déjà définie.

# 1. Rôle du SuperAdmin

Le SuperAdmin possède les privilèges suivants :

-   Créer un gestionnaire ou accorder les droits de gestionnaire à un user existant.
-   Valider une demande de création de chambre soumise par un user normal.
-   Lors de la validation, il attribue :
    -   un numéro unique de chambre
    -   un badge officiel
    -   les permissions du gestionnaire responsable
-   Supprimer une chambre si nécessaire.
-   Chaque action majeure du SuperAdmin déclenche une notification email vers le gestionnaire concerné.
-   Peut envoyer des messages en masse (email ou notification interne) à toutes / ou à certaines chambres.

# 2. Interface du SuperAdmin

L’interface est différente des autres rôles.  
Dès qu’il accède à la zone admin, il doit avoir le menu suivant :

1. Tableau de bord :

    - Nombre total des chambres
    - Nombre de demandes de création en attente
    - Nombre de gestionnaires actifs
    - Graphiques / histogrammes / pie charts selon les données existantes
    - Mini cards KPI visibles en un coup d'œil

2. Chambres :

    - Liste complète des chambres
    - Rechercher / filtrer / paginer
    - Voir les détails d’une chambre
    - Actions : valider, attribuer badge, attribuer numéro, supprimer, envoyer notification

3. Gestionnaires :

    - Liste de tous les gestionnaires
    - Promotion d’un user → gestionnaire
    - Désactivation / retrait du rôle de gestionnaire
    - Voir les chambres gérées

4. Notifications :
    - Page pour envoyer un message / email en masse
    - Option ciblée : vers une seule chambre ou plusieurs
    - Historique des envois

# 3. Ce que je veux que tu produises

-   La structure de dossiers propre (controllers, services, requests, policies).
-   Les écrans/pages en respectant la charte UX/UI existante.
-   Les composants réutilisables (cards, modals, tables, badges, menus).
-   Le workflow complet de validation des chambres (UI + logique).
-   Les policies d’accès claires (SuperAdmin uniquement).
-   Le système de notifications emails lié aux événements.
-   Les suggestions d’améliorations UX si nécessaire.

# 4. Contraintes et exigences

-   N’invente aucune logique qui existe déjà dans le projet ; utilise et étends proprement les classes existantes.
-   Utilise un code clean, commenté et maintenable.
-   Évite toute dépendance inutile.
-   Sois cohérent avec la structure du projet déjà existante.
-   Propose des améliorations UX GRANDES lignes avant de coder les vues.

Génère-moi d’abord :

1. une architecture claire
2. un plan détaillé des pages UI
3. la logique SuperAdmin proposée
4. puis le code étape par étape (sans casser l’existant)
