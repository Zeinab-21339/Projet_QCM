const CONFIG = {
    dureeQCM: 10 * 60,          // Durée du QCM en secondes (10 min)
    maxAvertissements: 2,        // Nb max d'avertissements avant invalidation
    urlInvalider: 'invalider.php', // Endpoint PHP d'invalidation
    urlResultat: 'resultat.php',   // Page de résultat après invalidation
    bloquerClicDroit: true,      // Désactiver le clic droit
    bloquerRaccourcis: true,     // Désactiver Ctrl+C, Ctrl+V, F12...
    bloquerSelection: true,      // Désactiver la sélection de texte
};
 

// ÉTAT GLOBAL
let qcmEnCours = false;
let tempsRestant = CONFIG.dureeQCM;
let intervalTimer = null;
let compteurAvertissements = 0;  // Compteur global (plein écran + onglet)
 

// 1. DÉMARRAGE DU QCM
/**
 * Appelée au clic sur le bouton "Commencer le QCM".
 * Lance le plein écran et démarre tous les mécanismes.
 */
function demarrerQCM() {
    lancerPleinEcran();
    qcmEnCours = true;
    demarrerTimer();
    console.log('[AntiTriche] QCM démarré.');
}
 
// Écoute du bouton de démarrage
const btnStart = document.getElementById('btn-start');
if (btnStart) {
    btnStart.addEventListener('click', function () {
        demarrerQCM();
    });
}
 

// 2. PLEIN ÉCRAN
/**
 * Demande au navigateur de passer en plein écran.
 * Compatible Chrome, Firefox, Safari, Edge.
 */
function lancerPleinEcran() {
    const elem = document.documentElement;
    if (elem.requestFullscreen) {
        elem.requestFullscreen().catch(err => {
            console.warn('[AntiTriche] Plein écran refusé :', err.message);
        });
    } else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen(); // Safari
    } else if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();    // Firefox ancien
    }
}
 
/**
 * Détecte la sortie du plein écran (touche Échap, etc.)
 */
document.addEventListener('fullscreenchange', function () {
    const estEnPleinEcran = !!document.fullscreenElement;
 
    if (!estEnPleinEcran && qcmEnCours) {
        compteurAvertissements++;
        console.warn('[AntiTriche] Sortie du plein écran. Avertissement', compteurAvertissements);
 
        if (compteurAvertissements >= CONFIG.maxAvertissements) {
            invaliderTentative('Sortie répétée du mode plein écran.');
        } else {
            afficherAvertissement(
                `⚠️ Vous avez quitté le mode plein écran !\nAvertissement ${compteurAvertissements}/${CONFIG.maxAvertissements}.`,
                function () {
                    lancerPleinEcran(); // Reprendre le plein écran
                }
            );
        }
    }
});
 
// Compatibilité Safari
document.addEventListener('webkitfullscreenchange', function () {
    const estEnPleinEcran = !!document.webkitFullscreenElement;
 
    if (!estEnPleinEcran && qcmEnCours) {
        compteurAvertissements++;
        if (compteurAvertissements >= CONFIG.maxAvertissements) {
            invaliderTentative('Sortie répétée du mode plein écran (Safari).');
        } else {
            afficherAvertissement(
                `⚠️ Vous avez quitté le mode plein écran !\nAvertissement ${compteurAvertissements}/${CONFIG.maxAvertissements}.`,
                lancerPleinEcran
            );
        }
    }
});
 

// 3. DÉTECTION CHANGEMENT D'ONGLET / MINIMISATION
/**
 * Utilise l'API Page Visibility pour détecter
 * quand l'utilisateur quitte l'onglet actif.
 */
document.addEventListener('visibilitychange', function () {
    if (document.hidden && qcmEnCours) {
        // L'utilisateur a quitté l'onglet
        compteurAvertissements++;
        console.warn('[AntiTriche] Changement d\'onglet. Avertissement', compteurAvertissements);
 
        if (compteurAvertissements >= CONFIG.maxAvertissements) {
            invaliderTentative('Changements d\'onglet répétés détectés.');
        }
    } else if (!document.hidden && qcmEnCours && compteurAvertissements > 0) {
        // L'utilisateur est revenu, on l'avertit
        afficherAvertissement(
            `⚠️ Changement d'onglet détecté !\nAvertissement ${compteurAvertissements}/${CONFIG.maxAvertissements}.`
        );
    }
});
 

// 4. TIMER — COMPTE À REBOURS
/**
 * Lance le compte à rebours.
 * Soumet automatiquement le QCM quand le temps est écoulé.
 */
function demarrerTimer() {
    tempsRestant = CONFIG.dureeQCM;
    afficherTemps(tempsRestant);
 
    intervalTimer = setInterval(function () {
        tempsRestant--;
        afficherTemps(tempsRestant);
 
        // Alerte visuelle à 2 minutes
        if (tempsRestant === 120) {
            const timer = document.getElementById('timer');
            if (timer) timer.style.color = 'orange';
        }
 
        // Alerte rouge à 30 secondes
        if (tempsRestant === 30) {
            const timer = document.getElementById('timer');
            if (timer) timer.style.color = 'red';
        }
 
        // Temps écoulé → soumission automatique
        if (tempsRestant <= 0) {
            clearInterval(intervalTimer);
            console.log('[AntiTriche] Temps écoulé. Soumission automatique.');
            soumettreQCM();
        }
 
    }, 1000);
}
 
/**
 * Formate et affiche le temps restant dans #timer.
 * Format MM:SS
 */
function afficherTemps(secondes) {
    const mins = Math.floor(secondes / 60);
    const secs = secondes % 60;
    const affichage = `⏱️ ${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
 
    const timer = document.getElementById('timer');
    if (timer) timer.textContent = affichage;
}
 
/**
 * Arrête le timer (ex : quand on soumet manuellement).
 */
function arreterTimer() {
    clearInterval(intervalTimer);
    intervalTimer = null;
}
 

// 5. BLOCAGE ACTIONS (optionnel selon CONFIG)
// Désactiver le clic droit
if (CONFIG.bloquerClicDroit) {
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
        return false;
    });
}
 
// Désactiver les raccourcis clavier dangereux
if (CONFIG.bloquerRaccourcis) {
    document.addEventListener('keydown', function (e) {
        const touchesBloquees = ['c', 'v', 'u', 's', 'a', 'p'];
        const estCtrl = e.ctrlKey || e.metaKey; // metaKey = Cmd sur Mac
 
        // Bloquer Ctrl+C, Ctrl+V, etc.
        if (estCtrl && touchesBloquees.includes(e.key.toLowerCase())) {
            e.preventDefault();
            return false;
        }
 
        // Bloquer F12 (DevTools)
        if (e.key === 'F12') {
            e.preventDefault();
            return false;
        }
 
        // Bloquer Ctrl+Shift+I (DevTools aussi)
        if (estCtrl && e.shiftKey && e.key.toLowerCase() === 'i') {
            e.preventDefault();
            return false;
        }
    });
}
 
// Désactiver la sélection de texte
if (CONFIG.bloquerSelection) {
    document.addEventListener('selectstart', function (e) {
        e.preventDefault();
    });
}
 

// 6. POPUP D'AVERTISSEMENT
/**
 * Affiche la popup d'avertissement avec un message.
 * @param {string}   message  - Texte affiché à l'utilisateur
 * @param {function} callback - Fonction appelée au clic sur "Reprendre"
 */
function afficherAvertissement(message, callback) {
    const overlay = document.getElementById('overlay-avertissement');
    const msg     = document.getElementById('msg-avertissement');
    const btnOk   = document.getElementById('btn-reprendre');
    const btnAban = document.getElementById('btn-abandonner');
 
    if (!overlay || !msg) {
        console.error('[AntiTriche] Éléments HTML manquants (#overlay-avertissement, #msg-avertissement)');
        return;
    }
 
    msg.textContent = message;
    overlay.style.display = 'flex';
 
    // Bouton "Reprendre"
    if (btnOk) {
        btnOk.onclick = function () {
            overlay.style.display = 'none';
            if (typeof callback === 'function') callback();
        };
    }
 
    // Bouton "Abandonner la tentative"
    if (btnAban) {
        btnAban.onclick = function () {
            invaliderTentative('Abandon volontaire après avertissement.');
        };
    }
}
 

// 7. INVALIDATION DE LA TENTATIVE
/**
 * Invalide la tentative en cours :
 *  - Arrête le timer
 *  - Envoie la raison au serveur PHP via fetch()
 *  - Redirige vers la page résultat
 *
 * @param {string} raison - Raison de l'invalidation
 */
function invaliderTentative(raison) {
    if (!qcmEnCours) return; // Éviter les appels multiples
 
    qcmEnCours = false;
    arreterTimer();
 
    console.warn('[AntiTriche] Tentative invalidée :', raison);
 
    fetch(CONFIG.urlInvalider, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ raison: raison })
    })
    .then(response => response.json())
    .then(data => {
        console.log('[AntiTriche] Réponse serveur :', data);
        window.location.href = CONFIG.urlResultat + '?invalide=1';
    })
    .catch(err => {
        // Même en cas d'erreur réseau, on redirige
        console.error('[AntiTriche] Erreur fetch :', err);
        window.location.href = CONFIG.urlResultat + '?invalide=1';
    });
}
 

// 8. SOUMISSION DU QCM
/**
 * Soumet le formulaire QCM (manuellement ou automatiquement).
 * À adapter selon votre structure HTML (id du formulaire).
 */
function soumettreQCM() {
    qcmEnCours = false;
    arreterTimer();
 
    const form = document.getElementById('form-qcm');
    if (form) {
        form.submit();
    } else {
        console.error('[AntiTriche] Formulaire #form-qcm introuvable.');
        window.location.href = CONFIG.urlResultat;
    }
}
