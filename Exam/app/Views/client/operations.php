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

        .result-message { padding: 12px 16px; border-radius: 8px; margin-top: 16px; display: none; }
        .result-message.success { display: block; background: #dcfce7; color: #16a34a; border: 1px solid #86efac; }
        .result-message.error { display: block; background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
        .result-message.info { display: block; background: #dbeafe; color: #2563eb; border: 1px solid #93c5fd; }

        .fee-info { background: #fef3c7; padding: 8px 12px; border-radius: 6px; font-size: 13px; color: #92400e; margin-top: 8px; }

        .card { background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 24px; }
        .card h3 { margin-bottom: 16px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-weight: 500; font-size: 14px; margin-bottom: 4px; }
        .form-group input { width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 14px; outline: none; }
        .form-group input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }

        .btn-primary { background: #2563eb; color: #fff; padding: 10px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-secondary { background: #f3f4f6; color: #111827; padding: 10px 24px; border: 1px solid #e5e7eb; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn-secondary:hover { background: #e5e7eb; }

        .form-actions { display: flex; gap: 10px; margin-top: 8px; flex-wrap: wrap; }

        @media (max-width: 768px) {
            .main { padding: 12px 16px; }
            .operation-tab { font-size: 12px; padding: 10px; }
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
                    <button class="btn-primary" onclick="deposit()">Effectuer le dépôt</button>
                    <button class="btn-secondary" onclick="document.getElementById('depositAmount').value=''">Réinitialiser</button>
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
                    <div id="withdrawalFeeInfo" class="fee-info" style="display:none;"></div>
                </div>
                <div class="form-actions">
                    <button class="btn-primary" onclick="withdrawal()">Effectuer le retrait</button>
                    <button class="btn-secondary" onclick="document.getElementById('withdrawalAmount').value='';document.getElementById('withdrawalFeeInfo').style.display='none'">Réinitialiser</button>
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
                    <div style="font-size:12px; color:#6b7280; margin-top:4px;">Format: 9 chiffres sans le 0</div>
                </div>
                <div class="form-group">
                    <label>Montant (Ar) <span style="color:#dc2626;">*</span></label>
                    <input type="number" id="transferAmount" placeholder="Ex: 5000" min="100" oninput="calculateTransferFee()" />
                    <div id="transferFeeInfo" class="fee-info" style="display:none;"></div>
                </div>
                <div class="form-actions">
                    <button class="btn-primary" onclick="transfer()">Effectuer le transfert</button>
                    <button class="btn-secondary" onclick="document.getElementById('destinationPhone').value='';document.getElementById('transferAmount').value='';document.getElementById('transferFeeInfo').style.display='none'">Réinitialiser</button>
                </div>
                <div id="transferResult" class="result-message"></div>
            </div>
        </div>
    </div>
</div>

<script>
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
    setTimeout(() => { el.style.display = 'none'; }, 5000);
}

function updateBalance(newBalance) {
    document.getElementById('currentBalance').textContent = newBalance.toLocaleString('fr-FR') + ' Ar';
}

// Dépôt
async function deposit() {
    const amount = document.getElementById('depositAmount').value;
    if (!amount || amount < 100) {
        showResult('depositResult', 'Veuillez entrer un montant valide (minimum 100 Ar)', 'error');
        return;
    }

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
        showResult('depositResult', '❌ Erreur lors de l\'opération', 'error');
    }
}

// Retrait - Calcul des frais
async function calculateWithdrawalFee() {
    const amount = document.getElementById('withdrawalAmount').value;
    if (!amount || amount < 100) {
        document.getElementById('withdrawalFeeInfo').style.display = 'none';
        return;
    }

    try {
        // Récupérer les barèmes depuis la base de données
        const response = await fetch('<?= site_url("frais/baremes") ?>');
        const data = await response.json();
        
        if (data.success) {
            const baremes = data.data;
            // Filtrer les barèmes de retrait
            const withdrawalFees = baremes.filter(b => b.type_operation === 'retrait');
            let fee = 0;
            
            for (const b of withdrawalFees) {
                if (parseFloat(amount) >= b.montant_min && parseFloat(amount) <= b.montant_max) {
                    fee = parseFloat(b.frais);
                    break;
                }
            }
            
            if (fee > 0) {
                document.getElementById('withdrawalFeeInfo').innerHTML = 
                    `💡 Frais estimés: <strong>${fee.toLocaleString('fr-FR')} Ar</strong><br>Total à débiter: <strong>${(parseFloat(amount) + fee).toLocaleString('fr-FR')} Ar</strong>`;
                document.getElementById('withdrawalFeeInfo').style.display = 'block';
            } else {
                document.getElementById('withdrawalFeeInfo').innerHTML = '⚠️ Aucun barème trouvé pour ce montant';
                document.getElementById('withdrawalFeeInfo').style.display = 'block';
            }
        }
    } catch (error) {
        console.log('Erreur lors du calcul des frais:', error);
    }
}

async function withdrawal() {
    const amount = document.getElementById('withdrawalAmount').value;
    if (!amount || amount < 100) {
        showResult('withdrawalResult', 'Veuillez entrer un montant valide (minimum 100 Ar)', 'error');
        return;
    }

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
            document.getElementById('withdrawalAmount').value = '';
            document.getElementById('withdrawalFeeInfo').style.display = 'none';
        } else {
            showResult('withdrawalResult', '❌ ' + data.message, 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showResult('withdrawalResult', '❌ Erreur lors de l\'opération', 'error');
    }
}

// Transfert - Calcul des frais
async function calculateTransferFee() {
    const amount = document.getElementById('transferAmount').value;
    if (!amount || amount < 100) {
        document.getElementById('transferFeeInfo').style.display = 'none';
        return;
    }

    try {
        const response = await fetch('<?= site_url("frais/baremes") ?>');
        const data = await response.json();
        
        if (data.success) {
            const baremes = data.data;
            const transferFees = baremes.filter(b => b.type_operation === 'transfert');
            let fee = 0;
            
            for (const b of transferFees) {
                if (parseFloat(amount) >= b.montant_min && parseFloat(amount) <= b.montant_max) {
                    fee = parseFloat(b.frais);
                    break;
                }
            }
            
            if (fee > 0) {
                document.getElementById('transferFeeInfo').innerHTML = 
                    `💡 Frais estimés: <strong>${fee.toLocaleString('fr-FR')} Ar</strong><br>Total à débiter: <strong>${(parseFloat(amount) + fee).toLocaleString('fr-FR')} Ar</strong>`;
                document.getElementById('transferFeeInfo').style.display = 'block';
            } else {
                document.getElementById('transferFeeInfo').innerHTML = '⚠️ Aucun barème trouvé pour ce montant';
                document.getElementById('transferFeeInfo').style.display = 'block';
            }
        }
    } catch (error) {
        console.log('Erreur lors du calcul des frais:', error);
    }
}

async function transfer() {
    const destination = document.getElementById('destinationPhone').value;
    const amount = document.getElementById('transferAmount').value;

    if (!destination) {
        showResult('transferResult', 'Veuillez entrer un numéro de destination', 'error');
        return;
    }
    if (!amount || amount < 100) {
        showResult('transferResult', 'Veuillez entrer un montant valide (minimum 100 Ar)', 'error');
        return;
    }

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
            document.getElementById('destinationPhone').value = '';
            document.getElementById('transferAmount').value = '';
            document.getElementById('transferFeeInfo').style.display = 'none';
        } else {
            showResult('transferResult', '❌ ' + data.message, 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showResult('transferResult', '❌ Erreur lors de l\'opération', 'error');
    }
}
</script>

</body>
</html>