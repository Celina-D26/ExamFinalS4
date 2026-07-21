<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'Mobile Money V2' ?></title>
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
            flex-wrap: wrap;
        }
        .operation-tab {
            flex: 1;
            padding: 12px 16px;
            text-align: center;
            cursor: pointer;
            border: none;
            background: transparent;
            font-weight: 600;
            color: #6b7280;
            transition: all 0.3s;
            font-size: 13px;
            min-width: 80px;
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
        .result-message.success { display: block; background: #dcfce7; color: #16a34a; border: 1px solid #86efac; }
        .result-message.error { display: block; background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }

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
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 10px 14px; 
            border: 1.5px solid #e5e7eb; 
            border-radius: 8px; 
            font-size: 14px; 
            outline: none; 
            transition: border-color 0.2s;
        }
        .form-group input:focus, .form-group select:focus { 
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

        .btn-success { 
            background: #22c55e; 
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
        .btn-success:hover { background: #16a34a; }

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

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
        }
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        .checkbox-group label {
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
        }

        .destinations-list {
            background: #f9fafb;
            padding: 12px;
            border-radius: 8px;
            margin-top: 8px;
            border: 1px solid #e5e7eb;
        }
        .destinations-list .dest-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .destinations-list .dest-item:last-child { border-bottom: none; }
        .destinations-list .dest-item .remove-btn {
            color: #dc2626;
            cursor: pointer;
            background: none;
            border: none;
            font-weight: bold;
        }
        .destinations-list .dest-item .remove-btn:hover { color: #991b1b; }

        .badge-other {
            background: #f59e0b;
            color: #fff;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
        }
        .badge-principal {
            background: #2563eb;
            color: #fff;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
        }

        @media (max-width: 768px) {
            .main { padding: 12px 16px; }
            .operation-tab { font-size: 11px; padding: 8px 10px; min-width: 60px; }
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
            <div style="font-size:20px; font-weight:600;">💳 Opérations V2</div>
            <span style="font-size:12px; color:#6b7280; background:#f3f4f6; padding:4px 12px; border-radius:20px;">
                Même opérateur uniquement
            </span>
        </div>

        <!-- Balance -->
        <div class="balance-display">
            <div class="label">Solde actuel</div>
            <div class="amount" id="currentBalance"><?= number_format($client['solde'] ?? 0, 0, ',', ' ') ?> Ar</div>
        </div>

        <!-- Opérateurs Info -->
        <div style="background:#fff; padding:12px 16px; border-radius:8px; border:1px solid #e5e7eb; margin-bottom:20px; display:flex; flex-wrap:wrap; gap:10px; justify-content:space-between; align-items:center;">
            <div>
                <span style="font-weight:600;">📱 Opérateur Principal:</span>
                <span class="badge-principal" style="margin-left:5px;">
                    <?= $principal_operateur['nom'] ?? 'Principal' ?>
                    (<?= implode(', ', json_decode($principal_operateur['prefixes'] ?? '["033","037"]', true)) ?>)
                </span>
            </div>
            <div>
                <span style="font-weight:600;">🔗 Autres Opérateurs:</span>
                <?php foreach ($other_operateurs as $op): ?>
                    <span class="badge-other" style="margin-left:5px;">
                        <?= $op['nom'] ?>
                        (<?= implode(', ', json_decode($op['prefixes'] ?? '[]', true)) ?>)
                        <?php if ($op['commission_pourcentage'] > 0): ?>
                            +<?= $op['commission_pourcentage'] ?>%
                        <?php endif; ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tabs -->
        <div class="operation-tabs">
            <button class="operation-tab active" data-tab="deposit" onclick="switchTab('deposit')">💰 Dépôt</button>
            <button class="operation-tab" data-tab="withdrawal" onclick="switchTab('withdrawal')">🏦 Retrait</button>
            <button class="operation-tab" data-tab="transfer" onclick="switchTab('transfer')">🔄 Transfert</button>
            <button class="operation-tab" data-tab="multisend" onclick="switchTab('multisend')">📤 Envoi Multiple</button>
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

        <!-- Retrait avec option inclure frais -->
        <div class="operation-panel" id="panel-withdrawal">
            <div class="card">
                <h3>Effectuer un retrait</h3>
                <p style="color:#6b7280; margin-bottom:16px;">Des frais seront appliqués selon le barème en vigueur.</p>
                <div class="form-group">
                    <label>Montant (Ar) <span style="color:#dc2626;">*</span></label>
                    <input type="number" id="withdrawalAmount" placeholder="Ex: 5000" min="100" oninput="calculateWithdrawalFee()" />
                    <div id="withdrawalFeeInfo" class="fee-info"></div>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="withdrawalIncludeFees" onchange="calculateWithdrawalFee()" />
                    <label for="withdrawalIncludeFees">💰 Inclure les frais dans le montant</label>
                </div>
                <div style="font-size:12px; color:#6b7280; margin-bottom:16px;">
                    <span id="withdrawalAmountInfo">Montant reçu: <strong id="withdrawalAmountReceived">-</strong> Ar</span>
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

        <!-- Transfert simple -->
        <div class="operation-panel" id="panel-transfer">
            <div class="card">
                <h3>Effectuer un transfert</h3>
                <p style="color:#6b7280; margin-bottom:8px;">Transférez de l'argent vers un autre numéro <strong>même opérateur</strong>.</p>
                <p style="color:#f59e0b; font-size:13px; margin-bottom:16px;">⚠️ Les transferts vers d'autres opérateurs doivent utiliser l'<strong>Envoi Multiple</strong></p>
                <div class="form-group">
                    <label>Numéro du destinataire <span style="color:#dc2626;">*</span></label>
                    <input type="tel" id="destinationPhone" placeholder="Ex: 340000001" />
                    <div class="hint">Format: 9 chiffres sans le 0</div>
                    <div id="destPhoneCheck" style="font-size:12px; margin-top:4px; display:none;"></div>
                </div>
                <div class="form-group">
                    <label>Montant (Ar) <span style="color:#dc2626;">*</span></label>
                    <input type="number" id="transferAmount" placeholder="Ex: 5000" min="100" oninput="calculateTransferFee()" />
                    <div id="transferFeeInfo" class="fee-info"></div>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="transferIncludeFees" onchange="calculateTransferFee()" />
                    <label for="transferIncludeFees">💰 Inclure les frais dans le montant</label>
                </div>
                <div style="font-size:12px; color:#6b7280; margin-bottom:16px;">
                    <span id="transferAmountInfo">Montant reçu: <strong id="transferAmountReceived">-</strong> Ar</span>
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

        <!-- Envoi Multiple -->
        <div class="operation-panel" id="panel-multisend">
            <div class="card">
                <h3>📤 Envoi Multiple</h3>
                <p style="color:#6b7280; margin-bottom:8px;">Envoyez un montant total vers plusieurs numéros <strong>même opérateur</strong>.</p>
                <p style="color:#f59e0b; font-size:13px; margin-bottom:16px;">⚠️ Tous les destinataires doivent être du même opérateur</p>
                
                <div class="form-group">
                    <label>Montant total (Ar) <span style="color:#dc2626;">*</span></label>
                    <input type="number" id="multiAmount" placeholder="Ex: 15000" min="100" oninput="calculateMultiFee()" />
                    <div id="multiFeeInfo" class="fee-info"></div>
                </div>
                
                <div class="form-group">
                    <label>Ajouter un destinataire <span style="color:#dc2626;">*</span></label>
                    <div style="display:flex; gap:10px;">
                        <input type="tel" id="multiDestination" placeholder="Ex: 340000001" style="flex:1;" />
                        <button class="btn-success" onclick="addDestination()" style="white-space:nowrap;">➕ Ajouter</button>
                    </div>
                    <div class="hint">Format: 9 chiffres sans le 0</div>
                </div>
                
                <div id="destinationsList" class="destinations-list">
                    <div style="color:#6b7280; text-align:center; padding:10px;">
                        Aucun destinataire ajouté
                    </div>
                </div>
                
                <div style="font-size:13px; color:#6b7280; margin:12px 0;">
                    <span id="multiInfo">Montant par personne: <strong id="multiPerPerson">-</strong> Ar</span>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="multiIncludeFees" onchange="calculateMultiFee()" />
                    <label for="multiIncludeFees">💰 Inclure les frais dans le montant total</label>
                </div>
                
                <div class="form-actions">
                    <button class="btn-primary" id="multiBtn" onclick="transferMultiple()">
                        <span id="multiSpinner" class="loading-spinner" style="display:none;"></span>
                        Envoyer à tous
                    </button>
                    <button class="btn-secondary" onclick="resetMulti()">Réinitialiser</button>
                </div>
                <div id="multiResult" class="result-message"></div>
            </div>
        </div>
    </div>
</div>

<script>
// ============================================================
// BARÈMES PRÉDÉFINIS
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

let loadedFees = { withdrawal: [], transfer: [] };
let destinations = [];

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
    setTimeout(() => { el.style.display = 'none'; }, 8000);
}

function updateBalance(newBalance) {
    document.getElementById('currentBalance').textContent = newBalance.toLocaleString('fr-FR') + ' Ar';
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
// CHARGEMENT DES BARÈMES
// ============================================================

async function loadFees() {
    try {
        const response = await fetch('<?= site_url("frais/baremes") ?>', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
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
        } else {
            loadedFees.withdrawal = DEFAULT_FEES.withdrawal;
            loadedFees.transfer = DEFAULT_FEES.transfer;
        }
    } catch (error) {
        loadedFees.withdrawal = DEFAULT_FEES.withdrawal;
        loadedFees.transfer = DEFAULT_FEES.transfer;
    }
}

// ============================================================
// DÉPÔT
// ============================================================

async function deposit() {
    const amount = document.getElementById('depositAmount').value;
    if (!amount || parseFloat(amount) < 100) {
        showResult('depositResult', '⚠️ Montant invalide (minimum 100 Ar)', 'error');
        return;
    }

    const btn = document.getElementById('depositBtn');
    const spinner = document.getElementById('depositSpinner');
    btn.disabled = true;
    spinner.style.display = 'inline-block';

    try {
        const response = await fetch('<?= site_url("client/operations/deposit") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
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
        showResult('depositResult', '❌ Erreur de connexion', 'error');
    } finally {
        btn.disabled = false;
        spinner.style.display = 'none';
    }
}

// ============================================================
// RETRAIT
// ============================================================

function calculateWithdrawalFee() {
    const amount = document.getElementById('withdrawalAmount').value;
    const includeFees = document.getElementById('withdrawalIncludeFees').checked;
    const feeInfo = document.getElementById('withdrawalFeeInfo');
    const amountReceived = document.getElementById('withdrawalAmountReceived');
    
    if (!amount || parseFloat(amount) < 100) {
        feeInfo.className = 'fee-info';
        feeInfo.innerHTML = '';
        amountReceived.textContent = '-';
        return;
    }

    const val = parseFloat(amount);
    const fee = getFee('retrait', val);
    
    if (fee > 0) {
        const total = includeFees ? val : val + fee;
        const received = includeFees ? val - fee : val;
        
        feeInfo.className = 'fee-info show';
        feeInfo.innerHTML = `
            💡 Frais: <strong>${fee.toLocaleString('fr-FR')} Ar</strong><br>
            Total à débiter: <strong>${total.toLocaleString('fr-FR')} Ar</strong>
        `;
        feeInfo.style.background = '#fef3c7';
        feeInfo.style.color = '#92400e';
        feeInfo.style.borderColor = '#fde68a';
        
        amountReceived.textContent = received.toLocaleString('fr-FR');
    } else {
        feeInfo.className = 'fee-info show';
        feeInfo.innerHTML = '⚠️ Aucun barème trouvé';
        feeInfo.style.background = '#fee2e2';
        feeInfo.style.color = '#dc2626';
        feeInfo.style.borderColor = '#fca5a5';
        amountReceived.textContent = '-';
    }
}

async function withdrawal() {
    const amount = document.getElementById('withdrawalAmount').value;
    const includeFees = document.getElementById('withdrawalIncludeFees').checked;
    
    if (!amount || parseFloat(amount) < 100) {
        showResult('withdrawalResult', '⚠️ Montant invalide (minimum 100 Ar)', 'error');
        return;
    }

    const btn = document.getElementById('withdrawalBtn');
    const spinner = document.getElementById('withdrawalSpinner');
    btn.disabled = true;
    spinner.style.display = 'inline-block';

    try {
        const response = await fetch('<?= site_url("client/operations/withdrawal") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ amount: parseFloat(amount), include_fees: includeFees })
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
        showResult('withdrawalResult', '❌ Erreur de connexion', 'error');
    } finally {
        btn.disabled = false;
        spinner.style.display = 'none';
    }
}

function resetWithdrawal() {
    document.getElementById('withdrawalAmount').value = '';
    document.getElementById('withdrawalFeeInfo').className = 'fee-info';
    document.getElementById('withdrawalFeeInfo').innerHTML = '';
    document.getElementById('withdrawalIncludeFees').checked = false;
    document.getElementById('withdrawalAmountReceived').textContent = '-';
    document.getElementById('withdrawalResult').style.display = 'none';
}

// ============================================================
// TRANSFERT
// ============================================================

function calculateTransferFee() {
    const amount = document.getElementById('transferAmount').value;
    const includeFees = document.getElementById('transferIncludeFees').checked;
    const feeInfo = document.getElementById('transferFeeInfo');
    const amountReceived = document.getElementById('transferAmountReceived');
    
    if (!amount || parseFloat(amount) < 100) {
        feeInfo.className = 'fee-info';
        feeInfo.innerHTML = '';
        amountReceived.textContent = '-';
        return;
    }

    const val = parseFloat(amount);
    const fee = getFee('transfert', val);
    
    if (fee > 0) {
        const total = includeFees ? val : val + fee;
        const received = includeFees ? val - fee : val;
        
        feeInfo.className = 'fee-info show';
        feeInfo.innerHTML = `
            💡 Frais: <strong>${fee.toLocaleString('fr-FR')} Ar</strong><br>
            Total à débiter: <strong>${total.toLocaleString('fr-FR')} Ar</strong>
        `;
        feeInfo.style.background = '#fef3c7';
        feeInfo.style.color = '#92400e';
        feeInfo.style.borderColor = '#fde68a';
        
        amountReceived.textContent = received.toLocaleString('fr-FR');
    } else {
        feeInfo.className = 'fee-info show';
        feeInfo.innerHTML = '⚠️ Aucun barème trouvé';
        feeInfo.style.background = '#fee2e2';
        feeInfo.style.color = '#dc2626';
        feeInfo.style.borderColor = '#fca5a5';
        amountReceived.textContent = '-';
    }
}

async function transfer() {
    const destination = document.getElementById('destinationPhone').value;
    const amount = document.getElementById('transferAmount').value;
    const includeFees = document.getElementById('transferIncludeFees').checked;

    if (!destination) {
        showResult('transferResult', '⚠️ Numéro de destination requis', 'error');
        return;
    }
    if (!amount || parseFloat(amount) < 100) {
        showResult('transferResult', '⚠️ Montant invalide (minimum 100 Ar)', 'error');
        return;
    }

    const btn = document.getElementById('transferBtn');
    const spinner = document.getElementById('transferSpinner');
    btn.disabled = true;
    spinner.style.display = 'inline-block';

    try {
        const response = await fetch('<?= site_url("client/operations/transferSimple") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ 
                destination_phone: destination, 
                amount: parseFloat(amount),
                include_fees: includeFees
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
        showResult('transferResult', '❌ Erreur de connexion', 'error');
    } finally {
        btn.disabled = false;
        spinner.style.display = 'none';
    }
}

function resetTransfer() {
    document.getElementById('destinationPhone').value = '';
    document.getElementById('transferAmount').value = '';
    document.getElementById('transferFeeInfo').className = 'fee-info';
    document.getElementById('transferFeeInfo').innerHTML = '';
    document.getElementById('transferIncludeFees').checked = false;
    document.getElementById('transferAmountReceived').textContent = '-';
    document.getElementById('transferResult').style.display = 'none';
    document.getElementById('destPhoneCheck').style.display = 'none';
}

// Vérification du numéro de destination
document.getElementById('destinationPhone').addEventListener('input', function() {
    const phone = this.value;
    const check = document.getElementById('destPhoneCheck');
    if (phone.length >= 3) {
        // Vérifier si c'est le même opérateur
        const principalPrefixes = <?= json_encode(array_map(function($p) { 
            return $p; 
        }, json_decode($principal_operateur['prefixes'] ?? '["033","037"]', true))); ?>;
        
        const prefix = phone.substring(0, 3);
        if (principalPrefixes.includes(prefix)) {
            check.style.display = 'block';
            check.style.color = '#16a34a';
            check.innerHTML = '✅ Numéro du même opérateur';
        } else {
            check.style.display = 'block';
            check.style.color = '#f59e0b';
            check.innerHTML = '⚠️ Numéro d\'un autre opérateur. Utilisez l\'Envoi Multiple.';
        }
    } else {
        check.style.display = 'none';
    }
});

// ============================================================
// ENVOI MULTIPLE
// ============================================================

function addDestination() {
    const input = document.getElementById('multiDestination');
    const phone = input.value.trim();
    
    if (!phone) {
        alert('Veuillez entrer un numéro');
        return;
    }
    
    if (destinations.includes(phone)) {
        alert('Ce numéro est déjà dans la liste');
        return;
    }
    
    // Vérifier que c'est le même opérateur
    const principalPrefixes = <?= json_encode(array_map(function($p) { 
        return $p; 
    }, json_decode($principal_operateur['prefixes'] ?? '["033","037"]', true))); ?>;
    
    const prefix = phone.substring(0, 3);
    if (!principalPrefixes.includes(prefix)) {
        alert('❌ Ce numéro n\'est pas du même opérateur');
        return;
    }
    
    destinations.push(phone);
    input.value = '';
    renderDestinations();
    calculateMultiFee();
}

function removeDestination(index) {
    destinations.splice(index, 1);
    renderDestinations();
    calculateMultiFee();
}

function renderDestinations() {
    const container = document.getElementById('destinationsList');
    if (destinations.length === 0) {
        container.innerHTML = '<div style="color:#6b7280; text-align:center; padding:10px;">Aucun destinataire ajouté</div>';
        return;
    }
    
    let html = '';
    destinations.forEach((phone, index) => {
        html += `
            <div class="dest-item">
                <span>📱 ${phone}</span>
                <button class="remove-btn" onclick="removeDestination(${index})">✕</button>
            </div>
        `;
    });
    container.innerHTML = html;
}

function calculateMultiFee() {
    const amount = document.getElementById('multiAmount').value;
    const includeFees = document.getElementById('multiIncludeFees').checked;
    const feeInfo = document.getElementById('multiFeeInfo');
    const perPerson = document.getElementById('multiPerPerson');
    
    if (!amount || parseFloat(amount) < 100 || destinations.length === 0) {
        feeInfo.className = 'fee-info';
        feeInfo.innerHTML = '';
        perPerson.textContent = '-';
        return;
    }

    const val = parseFloat(amount);
    const nb = destinations.length;
    const fee = getFee('transfert', val);
    
    if (fee > 0) {
        const total = includeFees ? val : val + fee;
        const perPersonAmount = includeFees ? (val - fee) / nb : val / nb;
        
        feeInfo.className = 'fee-info show';
        feeInfo.innerHTML = `
            💡 Frais totaux: <strong>${fee.toLocaleString('fr-FR')} Ar</strong><br>
            Total à débiter: <strong>${total.toLocaleString('fr-FR')} Ar</strong>
        `;
        feeInfo.style.background = '#fef3c7';
        feeInfo.style.color = '#92400e';
        feeInfo.style.borderColor = '#fde68a';
        
        perPerson.textContent = perPersonAmount.toLocaleString('fr-FR');
    } else {
        feeInfo.className = 'fee-info show';
        feeInfo.innerHTML = '⚠️ Aucun barème trouvé';
        feeInfo.style.background = '#fee2e2';
        feeInfo.style.color = '#dc2626';
        feeInfo.style.borderColor = '#fca5a5';
        perPerson.textContent = '-';
    }
}

async function transferMultiple() {
    const amount = document.getElementById('multiAmount').value;
    const includeFees = document.getElementById('multiIncludeFees').checked;

    if (!amount || parseFloat(amount) < 100) {
        showResult('multiResult', '⚠️ Montant total invalide (minimum 100 Ar)', 'error');
        return;
    }
    if (destinations.length < 2) {
        showResult('multiResult', '⚠️ Ajoutez au moins 2 destinataires', 'error');
        return;
    }

    const btn = document.getElementById('multiBtn');
    const spinner = document.getElementById('multiSpinner');
    btn.disabled = true;
    spinner.style.display = 'inline-block';

    try {
        const response = await fetch('<?= site_url("client/operations/transferMultiple") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ 
                amount: parseFloat(amount),
                destinations: destinations,
                include_fees: includeFees
            })
        });
        const data = await response.json();

        if (data.success) {
            showResult('multiResult', `✅ ${data.message} (Frais: ${data.fee.toLocaleString('fr-FR')} Ar)`, 'success');
            updateBalance(data.new_balance);
            resetMulti();
        } else {
            showResult('multiResult', '❌ ' + data.message, 'error');
        }
    } catch (error) {
        showResult('multiResult', '❌ Erreur de connexion', 'error');
    } finally {
        btn.disabled = false;
        spinner.style.display = 'none';
    }
}

function resetMulti() {
    destinations = [];
    renderDestinations();
    document.getElementById('multiAmount').value = '';
    document.getElementById('multiFeeInfo').className = 'fee-info';
    document.getElementById('multiFeeInfo').innerHTML = '';
    document.getElementById('multiIncludeFees').checked = false;
    document.getElementById('multiPerPerson').textContent = '-';
    document.getElementById('multiResult').style.display = 'none';
}

// ============================================================
// INITIALISATION
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    loadFees();
});
</script>

</body>
</html>