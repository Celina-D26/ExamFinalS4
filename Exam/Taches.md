## Liens Utiles

- **Base de données :** `app/Database/sysinfo.db`
- **Logs :** `writable/logs/`
- **Cache :** `writable/cache/`
- **Session :** `writable/session/`


## cote operateur(Iony ETU3939)
# Version1
## cote operateur
-Creation migartion bareme[ok]
-creation seeder [ok]
-debueugage erreur base [ok]
-creation frais controller [ok]
-creation frais model [ok]
-creation view frais [ok]
-test sur navigateur [ok]
-degueugage erreur migration [ok]
-creation migration et seeder compte client [ok]
-creation compte controller [ok]
-creation compte model [ok]
-creation view compte client [ok]
-mise en place les sidebar dans les view [ok]
-relation avec tableau de bord [ok]

# Version2
## Coté Opérateur (Administration)
1. Gestion des Préfixes
    Creation migration prefixes [ok]
    Creation seeder prefixes [ok]
    Creation prefixes controller [ok]
    Creation prefixes model [ok]
    Creation view prefixes [ok]
    Test sur navigateur [ok]
    Degueugage erreur colonne [ok]
    Ajout des commissions inter-opérateur [ok]
    Mise en place sidebar prefixes [ok]

2. Situation des Gains
    Creation gains controller [ok]
    Creation gains model [ok]
    Creation view gains [ok]
    Creation view montants par operateur [ok]
    Degueugage erreur view [ok]
    Integration des commissions inter-opérateur [ok]
    Separation gains meme operateur / autres operateurs [ok]
    Export CSV des gains [ok]
    Export PDF des gains [encour]
    Mise en place sidebar gains [ok]
    
    
## Fichiers Clés par Fonctionnalité
1. Gestion des Frais
    app/Controllers/FraisController.php
    app/Models/FraisBaremeModel.php
    app/Views/frais/index.php
    app/Database/Migrations/2026-07-20-062329_CreateFraisBaremesTable.php
    app/Database/Seeds/FraisBaremeSeeder.php

2. Gestion des Préfixes
    app/Controllers/PrefixeController.php
    app/Models/PrefixeModel.php
    app/Views/prefixes/index.php
    app/Views/prefixes/edit.php
    app/Database/Migrations/2026-07-20-054320_CreatePrefixesTable.php
    app/Database/Seeds/PrefixesSeeder.php

3. Situation des Gains
    app/Controllers/GainsController.php
    app/Models/GainsModel.php
    app/Views/gains/index.php
    app/Views/gains/montants.php

## cote client (Célina ETU004372)
 1. Authentification
- [ok] Login automatique avec numéro de téléphone
- [ok] Pas d'inscription préalable - Création automatique du compte
- [ok] Gestion des sessions - Connexion/Déconnexion
- [ok] Redirection sécurisée- après login

2. Opérations

 a) Dépôt
- [ok] Dépôt automatique (simulation)
- [ok] Validation du montant (minimum 100 Ar)
- [ok] Mise à jour du solde en temps réel
- [ok] Enregistrement de la transaction
- [ok] Affichage du résultat (succès/erreur)
- [ok] Correction : Gestion des erreurs de montant

b). Retrait
- [ok] Calcul automatique des frais selon le barème
- [ok] Option "Inclure les frais dans le montant"
- [ok] Vérification du solde avant retrait
- [ok] Mise à jour du solde en temps réel
- [ok] Enregistrement de la transaction
- [ok] Affichage du résultat (succès/erreur)
- [ok] Correction : Validation des données POST

c). Transfert
- [x] Transfert vers un autre numéro
- [x] Vérification de l'existence du destinataire
- [x] Calcul automatique des frais
- [x] Option "Inclure les frais dans le montant"
- [x] Vérification du solde avant transfert
- [x] Mise à jour du solde en temps réel
- [x] Enregistrement de la transaction
- [x] Création automatique du compte destinataire
- [x] Correction : Validation des données POST


d). Envoi Multiple (Version V2)
- [ok] Envoi vers plusieurs numéros
- [ok] Division équitable du montant
- [ok] Vérification de l'existence des destinataires
- [ok] Même opérateur uniquement
- [ok]Option "Inclure les frais dans le montant total"
- [ok] Vérification du solde avant envoi
- [ok] Mise à jour du solde en temps réel
- [ok] Enregistrement des transactions

e). Historique
- [ok] Liste des transactions du client
- [ok] Filtrage par type (dépôt, retrait, transfert)
- [ok] Affichage de la date et de l'heure
- [ok] Numéro de référence de la transaction
- [ok] Affichage des frais appliqués
- [ok] Correction : Liaison correcte des transactions avec le client


## Interface

1. Dashboard
- [ok] Affichage du solde disponible
- [ok] Boutons d'actions rapides (4 opérations)
- [ok] Statistiques des transactions
- [ok] Liste des dernières transactions
- [ok] Correction : Relation dashboard et client

2. Sidebar
- [ok] Navigation simplifiée
- [ok] Affichage du nom et numéro de l'utilisateur
- [ok] Bouton de déconnexion
- [ok] Correction : Structure propre et fonctionnelle

3. Debug Base de Données
- [ok] Vérification des colonnes manquantes
- [ok] Ajout des colonnes `commission_inter_operateur`
- [ok] Ajout des colonnes `operateur_destinataire`
- [ok] Correction des noms de colonnes
- [ok] Correction : Colonne `prefix` en `prefixe`


