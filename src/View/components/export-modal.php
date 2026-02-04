<!-- Modal d'Exportation AquaView -->
<div id="exportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Exporter les données</h3>
            <button onclick="closeExportModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="exportForm" class="space-y-4">
            <!-- Format d'exportation -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Format d'exportation</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="format" value="json" checked class="mr-2">
                        <div>
                            <div class="font-medium">JSON</div>
                            <div class="text-xs text-gray-500">Données structurées</div>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="format" value="csv" class="mr-2">
                        <div>
                            <div class="font-medium">CSV</div>
                            <div class="text-xs text-gray-500">Tableur Excel</div>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="format" value="netcdf" class="mr-2">
                        <div>
                            <div class="font-medium">NetCDF</div>
                            <div class="text-xs text-gray-500">Format scientifique</div>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="format" value="png" class="mr-2">
                        <div>
                            <div class="font-medium">PNG</div>
                            <div class="text-xs text-gray-500">Graphique</div>
                        </div>
                    </label>
                </div>
            </div>
            
            <!-- Métrique -->
            <div>
                <label for="exportMetric" class="block text-sm font-medium text-gray-700 mb-2">Métrique</label>
                <select id="exportMetric" name="metric" class="w-full p-2 border border-gray-300 rounded-md">
                    <option value="dissoxygen">Oxygène dissous</option>
                    <option value="temperature">Température</option>
                    <option value="salinity">Salinité</option>
                    <option value="ph">pH</option>
                </select>
            </div>
            
            <!-- Période -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Période</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="periodType" value="years" checked class="mr-2">
                        <span>Dernières</span>
                        <input type="number" name="periode" value="1" min="1" max="50" class="ml-2 w-16 p-1 border rounded">
                        <span class="ml-1">année(s)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="periodType" value="custom" class="mr-2">
                        <span>Période personnalisée:</span>
                    </label>
                    <div id="customPeriod" class="ml-6 space-y-2 hidden">
                        <input type="date" name="start_date" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Date de début">
                        <input type="date" name="end_date" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Date de fin">
                    </div>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeExportModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Exporter
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openExportModal() {
    document.getElementById('exportModal').classList.remove('hidden');
}

function closeExportModal() {
    document.getElementById('exportModal').classList.add('hidden');
}

// Gestion du type de période
document.querySelectorAll('input[name="periodType"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const customPeriod = document.getElementById('customPeriod');
        if (this.value === 'custom') {
            customPeriod.classList.remove('hidden');
        } else {
            customPeriod.classList.add('hidden');
        }
    });
});

// Soumission du formulaire
document.getElementById('exportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const params = new URLSearchParams();
    
    // Ajout des paramètres
    params.append('format', formData.get('format'));
    params.append('metric', formData.get('metric'));
    
    if (formData.get('periodType') === 'years') {
        params.append('periode', formData.get('periode'));
    } else {
        const startDate = formData.get('start_date');
        const endDate = formData.get('end_date');
        if (startDate) params.append('start_date', startDate);
        if (endDate) params.append('end_date', endDate);
    }
    
    // Téléchargement du fichier
    const url = '/api/export.php?' + params.toString();
    const link = document.createElement('a');
    link.href = url;
    link.download = ''; // Laisser le serveur définir le nom
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    closeExportModal();
});

// Fermeture au clic extérieur
document.getElementById('exportModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeExportModal();
    }
});
</script>
