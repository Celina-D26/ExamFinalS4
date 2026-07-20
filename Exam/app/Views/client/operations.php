<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'Mobile Money' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f3f4f6; }
        .app { display: flex; min-height: 100vh; }
        .main { flex: 1; padding: 20px 24px 32px; background: #f3f4f6; }

        .balance-display {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }
        .balance-display .amount { font-size: 32px; font-weight: 700; color: #2563eb; }
        .balance-display .label { font-size: 13px; color: #6b7280; }

        .operation-tabs {
            display: flex;
            gap: 0;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 24px;
            border: 1px solid #e5e7eb;
        }
        .operation-tab {
            flex: 1;
            padding: 14px;
            text-align: center;
            cursor: pointer;
            border: none;
            background: transparent;
            font-weight: 600;
            color: #6b7280;
            transition: all 0.3s;
            font-size: 14px;
        }
        .operation-tab.active { background: #2563eb; color: #fff; }
        .operation-tab:hover:not(.active) { background: #f3f4f6; }

        .operation-panel { display: none; animation: fadeIn 0.3s; }
        .operation-panel.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .result-message { 
            padding: 12px 16px; 
            border-radius: 8px; 
            margin-top: 16px; 
            display: none; 
            font-weight: 500;
        }
        .result-message.success { 
            display: block; 
            background: #dcfce7; 
            color: #16a34a; 
            border: 1px solid #86efac; 
        }
        .result-message.error { 
            display: block; 
            background: #fee2e2; 
            color: #dc2626; 
            border: 1px solid #fca5a5; 
        }

        .fee-info { 
            background: #fef3c7; 
            padding: 10px 14px; 
            border-radius: 8px; 
            font-size: 13px; 
            color: #92400e; 
            margin-top: 8px; 
            border: 1px solid #fde68a;
            display: none;
        }
        .fee-info.show { display: block; }

        .card { background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 24px; }
        .card h3 { margin-bottom: 16px; font-size: 18px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-weight: 500; font-size: 14px; margin-bottom: 4px; }
        .form-group input { 
            width: 100%; 
            padding: 10px 14px; 
            border: 1.5px solid #e5e7eb; 
            border-radius: 8px; 
            font-size: 14px; 
            outline: none; 
            transition: border-color 0.2s;
        }
        .form-group input:focus { 
            border-color: #2563eb; 
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1); 
        }
        .form-group .hint {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }

        .btn-primary { 
            background: #2563eb; 
            color: #fff; 
            padding: 10px 24px; 
            border: none; 
            border-radius: 8px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: background 0.2s; 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
        }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }

        .btn-secondary { 
            background: #f3f4f6; 
            color: #111827; 
            padding: 10px 24px; 
            border: 1px solid #e5e7eb; 
            border-radius: 8px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: background 0.2s; 
        }
        .btn-secondary:hover { background: #e5e7eb; }

        .form-actions { display: flex; gap: 10px; margin-top: 8px; flex-wrap: wrap; }

        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.6s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        @media (max-width: 768px) {
            .main { padding: 12px 16px; }
            .operation-tab { font-size: 12px; padding: 10px; }
            .form-actions { flex-direction: column; }
            .form-actions .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<div class="app">
    <?= view('partials/sidebar', ['username' => $username, 'phone_number' => $phone_number]) ?>
    
    <div class="main">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div style="font-size:20px; font-weight:600;">💳 Opérations</div>
        </div>

        <!-- Balance -->
        <div class="balance-display">
            <div class="label">Solde actuel</div>
            <div class="amount" id="currentBalance"><?= number_format($client['solde'] ?? 0, 0, ',', ' ') ?> Ar</div>
        </div>

        <!-- Tabs -->
        <div class="operation-tabs">
            <button class="operation-tab active" data-tab="deposit" onclick="switchTab('deposit')">💰 Dépôt</button>
            <button class="operation-tab" data-tab="withdrawal" onclick="switchTab('withdrawal')">🏦 Retrait</button>
            <button class="operation-tab" data-tab="transfer" onclick="switchTab('transfer')">🔄 Transfert</button>
        </div>

        <!-- Dépôt -->
        <div class="operation-panel active" id="panel-deposit">
            <div class="card">
                <h3>Effectuer un dépôt</h3>
                <p style="color:#6b7280; margin-bottom:16px;">Le dépôt est automatique. Entrez le montant à ajouter à votre compte.</p>
                <div class="form-group">
                    <label>Montant (Ar) <span style="color:#dc2626;">*</span></label>
                    <input type="number" id="depositAmount" placeholder="Ex: 10000" min="100" />
                </div>
                <div class="form-actions">
                    <button class="btn-primary" id="depositBtn" onclick="deposit()">
                        <span id="depositSpinner" class="loading-spinner" style="display:none;"></span>
                        Effectuer le dépôt
                    </button>
                    <button class="btn-secondary" onclick="document.getElementById('depositAmount').value='';document.getElementById('depositResult').style.display='none'">Réinitialiser</button>
                </div>
                <div id="depositResult" class="result-message"></div>
            </div>
        </div>

        <!-- Retrait -->
        <div class="operation-panel" id="panel-withdrawal">
            <div class="card">
                <h3>Effectuer un retrait</h3>
                <p style="color:#6b7280; margin-bottom:16px;">Des frais seront appliqués selon le barème en vigueur.</p>
                <div class="form-group">
                    <label>Montant (Ar) <span style="color:#dc2626;">*</span></label>
                    <input type="number" id="withdrawalAmount" placeholder="Ex: 5000" min="100" oninput="calculateWithdrawalFee()" />
                    <div id="withdrawalFeeInfo" class="fee-info"></div>
                </div>
                <div class="form-actions">
                    <button class="btn-primary" id="withdrawalBtn" onclick="withdrawal()">
                        <span id="withdrawalSpinner" class="loading-spinner" style="display:none;"></span>
                        Effectuer le retrait
                    </button>
                    <button class="btn-secondary" onclick="resetWithdrawal()">Réinitialiser</button>
                </div>
                <div id="withdrawalResult" class="result-message"></div>
            </div>
        </div>

        <!-- Transfert -->
        <div class="operation-panel" id="panel-transfer">
            <div class="card">
                <h3>Effectuer un transfert</h3>
                <p style="color:#6b7280; margin-bottom:16px;">Transférez de l'argent vers un autre numéro Mobile Money.</p>
                <div class="form-group">
                    <label>Numéro du destinataire <span style="color:#dc2626;">*</span></label>
                    <input type="tel" id="destinationPhone" placeholder="Ex: 340000001" />
                    <div class="hint">Format: 9 chiffres sans le 0</div>
                </div>
                <div class="form-group">
                    <label>Montant (Ar) <span style="color:#dc2626;">*</span></label>
                    <input type="number" id="transferAmount" placeholder="Ex: 5000" min="100" oninput="calculateTransferFee()" />
                    <div id="transferFeeInfo" class="fee-info"></div>
                </div>
                <div class="form-actions">
                    <button class="btn-primary" id="transferBtn" onclick="transfer()">
                        <span id="transferSpinner" class="loading-spinner" style="display:none;"></span>
                        Effectuer le transfert
                    </button>
                    <button class="btn-secondary" onclick="resetTransfer()">Réinitialiser</button>
                </div>
                <div id="transferResult" class="result-message"></div>
            </div>
        </div>
    </div>
</div>

<script>
// ============================================================
// BARÈMES PRÉDÉFINIS (utilisés si la base est vide)
// ============================================================

const DEFAULT_FEES = {
    withdrawal: [
        { min: 100, max: 1000, fee: 50 },
        { min: 1001, max: 5000, fee: 75 },
        { min: 5001, max: 10000, fee: 100 },
        { min: 10001, max: 25000, fee: 150 },
        { min: 25001, max: 50000, fee: 200 },
        { min: 50001, max: 100000, fee: 300 },
        { min: 100001, max: 250000, fee: 500 },
        { min: 250001, max: 500000, fee: 800 },
        { min: 500001, max: 1000000, fee: 1200 },
        { min: 1000001, max: 2000000, fee: 2000 }
    ],
    transfer: [
        { min: 100, max: 1000, fee: 25 },
        { min: 1001, max: 5000, fee: 50 },
        { min: 5001, max: 10000, fee: 75 },
        { min: 10001, max: 25000, fee: 100 },
        { min: 25001, max: 50000, fee: 150 },
        { min: 50001, max: 100000, fee: 200 },
        { min: 100001, max: 250000, fee: 300 },
        { min: 250001, max: 500000, fee: 500 },
        { min: 500001, max: 1000000, fee: 800 },
        { min: 1000001, max: 2000000, fee: 1200 }
    ]
};

// Variables pour stocker les barèmes chargés
let loadedFees = {
    withdrawal: [],
    transfer: []
};

// ============================================================
// FONCTIONS UTILITAIRES
// ============================================================

function switchTab(tab) {
    document.querySelectorAll('.operation-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.operation-panel').forEach(p => p.classList.remove('active'));
    document.querySelector(`.operation-tab[data-tab="${tab}"]`).classList.add('active');
    document.getElementById(`panel-${tab}`).classList.add('active');
}

function showResult(elementId, message, type) {
    const el = document.getElementById(elementId);
    el.className = 'result-message ' + type;
    el.textContent = message;
    el.style.display = 'block';
    setTimeout(() => { 
        el.style.display = 'none'; 
    }, 8000);
}

function updateBalance(newBalance) {
    const formatted = newBalance.toLocaleString('fr-FR') + ' Ar';
    document.getElementById('currentBalance').textContent = formatted;
}

function resetWithdrawal() {
    document.getElementById('withdrawalAmount').value = '';
    document.getElementById('withdrawalFeeInfo').className = 'fee-info';
    document.getElementById('withdrawalFeeInfo').innerHTML = '';
    document.getElementById('withdrawalResult').style.display = 'none';
}

function resetTransfer() {
    document.getElementById('destinationPhone').value = '';
    document.getElementById('transferAmount').value = '';
    document.getElementById('transferFeeInfo').className = 'fee-info';
    document.getElementById('transferFeeInfo').innerHTML = '';
    document.getElementById('transferResult').style.display = 'none';
}

// ============================================================
// CHARGEMENT DES BARÈMES
// ============================================================

async function loadFees() {
    try {
        const response = await fetch('<?= site_url("frais/baremes") ?>', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            // Barèmes chargés depuis la base
            const baremes = data.data;
            loadedFees.withdrawal = baremes.filter(b => b.type_operation === 'retrait').map(b => ({
                min: parseFloat(b.montant_min),
                max: parseFloat(b.montant_max),
                fee: parseFloat(b.frais)
            }));
            loadedFees.transfer = baremes.filter(b => b.type_operation === 'transfert').map(b => ({
                min: parseFloat(b.montant_min),
                max: parseFloat(b.montant_max),
                fee: parseFloat(b.frais)
            }));
            console.log('✅ Barèmes chargés depuis la base:', loadedFees);
        } else {
            // Utiliser les barèmes par défaut
            loadedFees.withdrawal = DEFAULT_FEES.withdrawal;
            loadedFees.transfer = DEFAULT_FEES.transfer;
            console.log('⚠️ Utilisation des barèmes par défaut');
        }
    } catch (error) {
        // En cas d'erreur, utiliser les barèmes par défaut
        loadedFees.withdrawal = DEFAULT_FEES.withdrawal;
        loadedFees.transfer = DEFAULT_FEES.transfer;
        console.log('⚠️ Erreur de chargement, utilisation des barèmes par défaut');
    }
    
    console.log('📊 Barèmes chargés:', {
        withdrawal: loadedFees.withdrawal.length,
        transfer: loadedFees.transfer.length
    });
}

function getFee(type, amount) {
    const fees = type === 'retrait' ? loadedFees.withdrawal : loadedFees.transfer;
    for (const f of fees) {
        if (amount >= f.min && amount <= f.max) {
            return f.fee;
        }
    }
    return 0;
}

// ============================================================
// FONCTION DÉPÔT
// ============================================================

async function deposit() {
    const amount = document.getElementById('depositAmount').value;
    
    if (!amount || parseFloat(amount) < 100) {
        showResult('depositResult', '⚠️ Veuillez entrer un montant valide (minimum 100 Ar)', 'error');
        return;
    }

    const btn = document.getElementById('depositBtn');
    const spinner = document.getElementById('depositSpinner');
    btn.disabled = true;
    spinner.style.display = 'inline-block';

    try {
        const response = await fetch('<?= site_url("client/operations/deposit") ?>', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ amount: parseFloat(amount) })
        });
        const data = await response.json();

        if (data.success) {
            showResult('depositResult', '✅ ' + data.message, 'success');
            updateBalance(data.new_balance);
            document.getElementById('depositAmount').value = '';
        } else {
            showResult('depositResult', '❌ ' + data.message, 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showResult('depositResult', '❌ Erreur de connexion au serveur', 'error');
    } finally {
        btn.disabled = false;
        spinner.style.display = 'none';
    }
}

// ============================================================
// FONCTION RETRAIT
// ============================================================

function calculateWithdrawalFee() {
    const amount = document.getElementById('withdrawalAmount').value;
    const feeInfo = document.getElementById('withdrawalFeeInfo');
    
    if (!amount || parseFloat(amount) < 100) {
        feeInfo.className = 'fee-info';
        feeInfo.innerHTML = '';
        return;
    }

    const val = parseFloat(amount);
    const fee = getFee('retrait', val);
    
    if (fee > 0) {
        feeInfo.className = 'fee-info show';
        feeInfo.innerHTML = `
            💡 Frais estimés: <strong>${fee.toLocaleString('fr-FR')} Ar</strong><br>
            Total à débiter: <strong>${(val + fee).toLocaleString('fr-FR')} Ar</strong>
        `;
        feeInfo.style.background = '#fef3c7';
        feeInfo.style.color = '#92400e';
        feeInfo.style.borderColor = '#fde68a';
    } else {
        feeInfo.className = 'fee-info show';
        feeInfo.innerHTML = '⚠️ Aucun barème trouvé pour ce montant';
        feeInfo.style.background = '#fee2e2';
        feeInfo.style.color = '#dc2626';
        feeInfo.style.borderColor = '#fca5a5';
    }
}

async function withdrawal() {
    const amount = document.getElementById('withdrawalAmount').value;
    
    if (!amount || parseFloat(amount) < 100) {
        showResult('withdrawalResult', '⚠️ Veuillez entrer un montant valide (minimum 100 Ar)', 'error');
        return;
    }

    const btn = document.getElementById('withdrawalBtn');
    const spinner = document.getElementById('withdrawalSpinner');
    btn.disabled = true;
    spinner.style.display = 'inline-block';

    try {
        const response = await fetch('<?= site_url("client/operations/withdrawal") ?>', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ amount: parseFloat(amount) })
        });
        const data = await response.json();

        if (data.success) {
            showResult('withdrawalResult', `✅ ${data.message} (Frais: ${data.fee.toLocaleString('fr-FR')} Ar)`, 'success');
            updateBalance(data.new_balance);
            resetWithdrawal();
        } else {
            showResult('withdrawalResult', '❌ ' + data.message, 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showResult('withdrawalResult', '❌ Erreur de connexion au serveur', 'error');
    } finally {
        btn.disabled = false;
        spinner.style.display = 'none';
    }
}

// ============================================================
// FONCTION TRANSFERT
// ============================================================

function calculateTransferFee() {
    const amount = document.getElementById('transferAmount').value;
    const feeInfo = document.getElementById('transferFeeInfo');
    
    if (!amount || parseFloat(amount) < 100) {
        feeInfo.className = 'fee-info';
        feeInfo.innerHTML = '';
        return;
    }

    const val = parseFloat(amount);
    const fee = getFee('transfert', val);
    
    if (fee > 0) {
        feeInfo.className = 'fee-info show';
        feeInfo.innerHTML = `
            💡 Frais estimés: <strong>${fee.toLocaleString('fr-FR')} Ar</strong><br>
            Total à débiter: <strong>${(val + fee).toLocaleString('fr-FR')} Ar</strong>
        `;
        feeInfo.style.background = '#fef3c7';
        feeInfo.style.color = '#92400e';
        feeInfo.style.borderColor = '#fde68a';
    } else {
        feeInfo.className = 'fee-info show';
        feeInfo.innerHTML = '⚠️ Aucun barème trouvé pour ce montant';
        feeInfo.style.background = '#fee2e2';
        feeInfo.style.color = '#dc2626';
        feeInfo.style.borderColor = '#fca5a5';
    }
}

async function transfer() {
    const destination = document.getElementById('destinationPhone').value;
    const amount = document.getElementById('transferAmount').value;

    if (!destination) {
        showResult('transferResult', '⚠️ Veuillez entrer un numéro de destination', 'error');
        return;
    }
    if (!amount || parseFloat(amount) < 100) {
        showResult('transferResult', '⚠️ Veuillez entrer un montant valide (minimum 100 Ar)', 'error');
        return;
    }

    const btn = document.getElementById('transferBtn');
    const spinner = document.getElementById('transferSpinner');
    btn.disabled = true;
    spinner.style.display = 'inline-block';

    try {
        const response = await fetch('<?= site_url("client/operations/transfer") ?>', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ 
                destination_phone: destination, 
                amount: parseFloat(amount) 
            })
        });
        const data = await response.json();

        if (data.success) {
            showResult('transferResult', `✅ ${data.message} (Frais: ${data.fee.toLocaleString('fr-FR')} Ar)`, 'success');
            updateBalance(data.new_balance);
            resetTransfer();
        } else {
            showResult('transferResult', '❌ ' + data.message, 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showResult('transferResult', '❌ Erreur de connexion au serveur', 'error');
    } finally {
        btn.disabled = false;
        spinner.style.display = 'none';
    }
}

// ============================================================
// INITIALISATION
// ============================================================

// Charger les barèmes au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    console.log('📱 Page Opérations chargée');
    loadFees();
});
</script>

</body>
</html>