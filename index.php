<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $session = session(); ?>

<!-- Header Section -->
<section class="bg-gradient-to-r from-blue-600 via-blue-700 to-cyan-600 text-white py-16">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <h1 class="text-5xl font-bold mb-4 font-[Poppins]">Rekapan Pengadaan</h1>
            <p class="text-xl font-medium font-[Poppins] mb-8">Informasi Pengadaan Bidang Perikanan Tangkap </p>
            
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 font-[Poppins] mb-3">Statistik Penerima Manfaat</h2>
            <p class="text-gray-600 font-[Poppins] text-lg">Analisis perbandingan penerima manfaat dengan total nelayan</p>
        </div>
        
        <!-- Year Filter for Statistics -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center gap-4 bg-white px-6 py-3 rounded-lg shadow-md">
                <label class="text-sm font-medium text-gray-700">Filter Statistik Tahun:</label>
                <select id="statsYearFilter" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Tahun</option>
                </select>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Top Row: Anggaran Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Total Pagu Anggaran Card -->
                <div class="bg-gradient-to-r from-cyan-500 to-blue-400 rounded-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold font-[Poppins] mb-1">Total Pagu Anggaran</h3>
                            <p class="text-3xl font-bold font-[Poppins]" id="totalPaguAnggaran">Rp 0</p>
                            <p class="text-cyan-100 text-sm">Seluruh pengadaan</p>
                        </div>
                        <div class="text-5xl opacity-80"></div>
                    </div>
                </div>
                
                <!-- Total Realisasi Card -->
                <div class="bg-gradient-to-r from-emerald-500 to-green-400 rounded-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold font-[Poppins] mb-1">Total Realisasi</h3>
                            <p class="text-3xl font-bold font-[Poppins]" id="totalRealisasiAnggaran">Rp 0</p>
                            <p class="text-emerald-100 text-sm">Pengadaan terlaksana</p>
                        </div>
                        <div class="text-5xl opacity-80"></div>
                    </div>
                </div>
            </div>
            
            <!-- Main Statistics Grid: Penerima Manfaat sejajar dengan Chart -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Left: Statistics Cards (Penerima Manfaat) -->
                <div class="space-y-4">
                    <!-- Total Nelayan Card -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold font-[Poppins] mb-1">Total Nelayan</h3>
                                <p class="text-3xl font-bold font-[Poppins]" id="totalNelayan"><?= number_format($total_nelayan) ?></p>
                                <p class="text-blue-100 text-sm">Terdaftar dalam sistem</p>
                            </div>
                            <div class="text-5xl opacity-80"></div>
                        </div>
                    </div>
                    
                    <!-- Penerima Manfaat Card -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold font-[Poppins] mb-1">Penerima Manfaat</h3>
                                <p class="text-3xl font-bold font-[Poppins]" id="totalPenerima">0</p>
                                <p class="text-green-100 text-sm">Tercakup</p>
                            </div>
                            <div class="text-5xl opacity-80"></div>
                        </div>
                    </div>
                
                    <!-- Coverage Card -->
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold font-[Poppins] mb-1">Persentase Cakupan</h3>
                                <p class="text-3xl font-bold font-[Poppins]" id="persentaseCoverage">0%</p>
                                <p class="text-purple-100 text-sm">Dari total nelayan</p>
                            </div>
                            <div class="text-5xl opacity-80"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Right: Pie Chart Container -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 font-[Poppins] mb-4 text-center">Distribusi Penerima Manfaat</h3>
                    <div class="relative">
                        <canvas id="beneficiaryChart" width="300" height="300" class="mx-auto"></canvas>
                    </div>
                    
                    <!-- Legend -->
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="flex items-center justify-center p-3 bg-green-100 rounded-lg">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                            <div class="text-center">
                                <p class="font-semibold text-gray-800" id="legendPenerima">0</p>
                                <p class="text-sm text-gray-600">Sudah Menerima</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center p-3 bg-orange-100 rounded-lg">
                            <div class="w-4 h-4 bg-orange-500 rounded-full mr-3"></div>
                            <div class="text-center">
                                <p class="font-semibold text-gray-800" id="legendBelum">0</p>
                                <p class="text-sm text-gray-600">Belum Menerima</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Status Indicator -->
            <div class="text-center">
                <div id="statusIndicator" class="inline-flex items-center rounded-full text-lg font-semibold px-6 py-3">
                    <span id="statusDot" class="w-3 h-3 rounded-full mr-3"></span>
                    <span id="statusText"></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Data Management Section -->
<div class="container mx-auto px-6 py-8">
    <!-- Add Button for Admin -->
    <?php if ($session->get('role') == 'admin' || $session->get('role') == 'tpi'): ?>
        <div class="text-center mb-8">
            <a href="<?= base_url('/pengadaan/create') ?>" 
                class="inline-flex items-center bg-blue-600 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:bg-blue-700 transform hover:scale-105 transition-all duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Data Pengadaan
            </a>
        </div>
    <?php endif; ?>

    <!-- Enhanced Filter Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h3 class="text-xl font-bold text-gray-800 font-[Poppins]">Filter & Pencarian Data</h3>
            <p class="text-gray-600 mt-1">Gunakan filter di bawah untuk mempersempit pencarian data</p>
        </div>
        
        <!-- Search and Export Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchInput" 
                           placeholder="Cari nama kegiatan, penyedia, atau kelompok..." 
                           class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base font-[Poppins]">
                </div>
            </div>
            
            <?php if ($session->get('role')=='admin') : ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Export Data</label>
                <a href="<?= base_url('pengadaan/download_excel') ?>" 
                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition duration-300 text-base font-[Poppins]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Unduh Excel
                </a>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Filter Controls -->
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Tahun</label>
                <select id="filterTahun" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Tahun</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Penyedia</label>
                <select id="filterPenyedia" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Penyedia</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tampilkan</label>
                <select id="itemsPerPage" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="5">5 per halaman</option>
                    <option value="10" selected>10 per halaman</option>
                    <option value="20">20 per halaman</option>
                    <option value="50">50 per halaman</option>
                    <option value="100">100 per halaman</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button id="resetFilter" 
                        class="w-full bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                    Reset Filter
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE CARD VIEW -->
    <div class="block md:hidden" id="mobileView">
        <div id="mobileCards" class="space-y-4"></div>
        
        <!-- Mobile Pagination Controls -->
        <div class="flex flex-col sm:flex-row justify-center items-center gap-2 sm:gap-4 mt-6 bg-white p-4 rounded-lg shadow-lg">
            <button id="prevPageMobile" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded disabled:opacity-50 disabled:cursor-not-allowed w-full sm:w-auto text-sm" disabled>
                ← Previous
            </button>
            <span id="pageInfoMobile" class="text-blue-700 font-semibold text-sm text-center py-2"></span>
            <button id="nextPageMobile" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded w-full sm:w-auto text-sm">
                Next →
            </button>
        </div>
    </div>

    <!-- DESKTOP TABLE VIEW -->
    <div class="hidden md:block bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 font-[Poppins]">Tabel Data Pengadaan</h3>
            <p class="text-gray-600 mt-1">Daftar lengkap data pengadaan dan kelompok penerima manfaat</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse table-pengadaan font-[Poppins]" id="dataTable">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-4 text-center text-sm font-semibold text-gray-700 w-16">No</th>
                        <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700">Nama Kegiatan</th>
                        <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700">Penyedia</th>
                        <th class="px-4 py-4 text-center text-sm font-semibold text-gray-700">Pagu Anggaran</th>
                        <th class="px-4 py-4 text-center text-sm font-semibold text-gray-700">Realisasi</th>
                        <th class="px-4 py-4 text-center text-sm font-semibold text-gray-700">Tahun</th>
                        <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700">Kelompok</th>
                        <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700">Alamat Kelompok</th>
                        <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700">Ketua Kelompok</th>
                        <th class="px-4 py-4 text-center text-sm font-semibold text-gray-700">Jumlah Anggota</th>
                        <?php if ($session->get('role') == 'admin') : ?>
                        <th class="px-4 py-4 text-center text-sm font-semibold text-gray-700 w-24">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>
        
        <!-- Desktop Pagination Controls -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 border-t border-gray-200">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-700">Showing</span>
                <span id="showingInfo" class="font-semibold text-gray-900"></span>
                <span class="text-sm text-gray-700">of</span>
                <span id="totalData" class="font-semibold text-gray-900"></span>
                <span class="text-sm text-gray-700">entries</span>
            </div>
            <div class="flex items-center gap-2">
                <button id="prevPage" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    ← Previous
                </button>
                <span id="pageInfo" class="text-blue-700 font-semibold px-4"></span>
                <button id="nextPage" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Next →
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
let allData = [];
let filteredData = [];
let currentPage = 1;
let limit = parseInt(document.getElementById('itemsPerPage').value);
let baseUrl = "<?= base_url() ?>";
let beneficiaryChart;
let totalNelayan = <?= $total_nelayan ?>;

// Statistics calculation functions
function calculateStatistics(data, year = '') {
    let filteredStatsData = data;
    
    // Filter by year if specified
    if (year) {
        filteredStatsData = data.filter(item => item.tahun === year);
    }
    
    // Calculate total penerima manfaat from jumlah_anggota
    let totalPenerimaManfaat = 0;
    let totalPagu = 0;
    let totalRealisasi = 0;
    filteredStatsData.forEach(item => {
        totalPagu += parseInt(item.pagu_anggaran) || 0;
        totalRealisasi += parseInt(item.realisasi_anggaran) || 0;
        if (item.kub && Array.isArray(item.kub)) {
            item.kub.forEach(kub => {
                totalPenerimaManfaat += parseInt(kub.jumlah_anggota) || 0;
            });
        }
    });
    
    let persentasePenerima = totalNelayan > 0 ? (totalPenerimaManfaat / totalNelayan) * 100 : 0;
    let belumMenerima = totalNelayan - totalPenerimaManfaat;
    
    return {
        totalPenerimaManfaat,
        persentasePenerima,
        belumMenerima,
        totalPagu,
        totalRealisasi
    };
}

function updateStatistics() {
    let selectedYear = document.getElementById('statsYearFilter').value;
    let stats = calculateStatistics(allData, selectedYear);
    
    // Update numbers with animation
    animateNumber('totalPenerima', stats.totalPenerimaManfaat);
    animatePercentage('persentaseCoverage', stats.persentasePenerima);
    
    // Update legend
    document.getElementById('legendPenerima').textContent = Number(stats.totalPenerimaManfaat).toLocaleString();
    document.getElementById('legendBelum').textContent = Number(stats.belumMenerima).toLocaleString();
    
    // Update Anggaran & Realisasi
    animateCurrency('totalPaguAnggaran', stats.totalPagu);
    animateCurrency('totalRealisasiAnggaran', stats.totalRealisasi);
    
    // Update chart
    updateChart(stats.totalPenerimaManfaat, stats.belumMenerima);
    
    // Update status indicator
    updateStatusIndicator(stats.persentasePenerima);
}

function animateCurrency(elementId, targetValue) {
    gsap.to(document.getElementById(elementId), {
        innerText: targetValue,
        duration: 1.5,
        snap: { innerText: 1000 },
        ease: "power2.out",
        onUpdate: function() {
            document.getElementById(elementId).innerHTML = "Rp " + Number(this.targets()[0].innerText).toLocaleString();
        }
    });
}

function animateNumber(elementId, targetValue) {
    gsap.to(document.getElementById(elementId), {
        innerText: targetValue,
        duration: 1.5,
        snap: { innerText: 1 },
        ease: "power2.out",
        onUpdate: function() {
            document.getElementById(elementId).innerHTML = Number(this.targets()[0].innerText).toLocaleString();
        }
    });
}

function animatePercentage(elementId, targetValue) {
    gsap.to(document.getElementById(elementId), {
        innerText: targetValue,
        duration: 2,
        snap: { innerText: 0.1 },
        ease: "power2.out",
        onUpdate: function() {
            document.getElementById(elementId).innerHTML = Number(this.targets()[0].innerText).toFixed(1) + '%';
        }
    });
}

function updateStatusIndicator(percentage) {
    const statusIndicator = document.getElementById('statusIndicator');
    const statusDot = document.getElementById('statusDot');
    const statusText = document.getElementById('statusText');
    
    // Remove existing classes
    statusIndicator.className = 'inline-flex items-center  rounded-full text-xs font-semibold';
    statusDot.className = ' rounded-full ';
    
    if (percentage >= 80) {
        statusIndicator.classList.add('bg-green-100', 'text-green-800');
        statusDot.classList.add('bg-green-600');

    } else if (percentage >= 60) {
        statusIndicator.classList.add('bg-blue-100', 'text-blue-800');
        statusDot.classList.add('bg-blue-600');

    } else if (percentage >= 40) {
        statusIndicator.classList.add('bg-yellow-100', 'text-yellow-800');
        statusDot.classList.add('bg-yellow-600');

    } else {
        statusIndicator.classList.add('bg-red-100', 'text-red-800');
        statusDot.classList.add('bg-red-600');

    }
}

// Initialize Pie Chart
function initChart() {
    const ctx = document.getElementById('beneficiaryChart').getContext('2d');
    
    beneficiaryChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Sudah Menerima', 'Belum Menerima'],
            datasets: [{
                data: [0, totalNelayan],
                backgroundColor: [
                    '#10B981', // Green
                    '#F59E0B'  // Orange
                ],
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverBorderWidth: 4,
                hoverBorderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label;
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: ${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '60%',
            animation: {
                animateRotate: true,
                duration: 2000
            }
        }
    });
}

function updateChart(penerima, belum) {
    if (beneficiaryChart) {
        beneficiaryChart.data.datasets[0].data = [penerima, belum];
        beneficiaryChart.update('active');
    }
}

function fetchData() {
    fetch(`<?= base_url('pengadaan/fetch_all_data') ?>`)
        .then(response => response.json())
        .then(result => {
            allData = result.data;
            filteredData = allData;
            populateFilters();
            populateStatsYearFilter();
            updateStatistics();
            renderData();
        });
}

function populateStatsYearFilter() {
    // Populate year filter for statistics
    const years = [...new Set(allData.map(item => item.tahun))].sort();
    const statsYearSelect = document.getElementById('statsYearFilter');
    
    // Clear existing options except "Semua Tahun"
    statsYearSelect.innerHTML = '<option value="">Semua Tahun</option>';
    
    years.forEach(year => {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        statsYearSelect.appendChild(option);
    });
}

function populateFilters() {
    // Populate year filter
    const years = [...new Set(allData.map(item => item.tahun))].sort();
    const yearSelect = document.getElementById('filterTahun');
    years.forEach(year => {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    });

    // Populate provider filter
    const providers = [...new Set(allData.map(item => item.penyedia))].sort();
    const providerSelect = document.getElementById('filterPenyedia');
    providers.forEach(provider => {
        const option = document.createElement('option');
        option.value = provider;
        option.textContent = provider;
        providerSelect.appendChild(option);
    });
}

function renderMobileCards() {
    const mobileCards = document.getElementById('mobileCards');
    mobileCards.innerHTML = "";

    let dataToShow = filteredData.length ? filteredData : allData;
    let startIndex = (currentPage - 1) * limit;
    let paginatedData = dataToShow.slice(startIndex, startIndex + limit);

    paginatedData.forEach((row, index) => {
        const kubArr = row.kub || [];
        
        let cardHTML = `
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-5 mobile-card hover:shadow-lg transition-shadow duration-300">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded">#${startIndex + index + 1}</span>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Pengadaan</span>
                </div>
                <div class="space-y-4">
                    <div>
                        <span class="text-xs text-gray-600 font-medium">Nama Kegiatan:</span>
                        <p class="font-semibold text-gray-900 break-words text-sm mt-1">${row.nama_kegiatan}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-600 font-medium">Penyedia:</span>
                        <p class="text-sm text-gray-900 break-words mt-1">${row.penyedia}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <span class="text-xs text-gray-600 font-medium">Pagu:</span>
                            <p class="text-sm text-gray-900 font-semibold">Rp ${Number(row.pagu_anggaran).toLocaleString()}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <span class="text-xs text-gray-600 font-medium">Realisasi:</span>
                            <p class="text-sm text-gray-900 font-semibold">Rp ${Number(row.realisasi_anggaran).toLocaleString()}</p>
                        </div>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-3">
                        <span class="text-xs text-blue-600 font-medium">Tahun:</span>
                        <p class="text-sm text-blue-900 font-semibold">${row.tahun}</p>
                    </div>
                    <div class="border-t pt-4 mt-4">
                        <span class="text-xs text-gray-600 font-medium block mb-3">Kelompok Penerima (${kubArr.length}):</span>`;

        if (kubArr.length > 0) {
            kubArr.forEach((kub, i) => {
                cardHTML += `
                    <div class="bg-green-50 rounded-lg p-3 mb-2 last:mb-0 border-l-4 border-green-500">
                        <p class="font-semibold text-sm text-gray-800">${kub.nama_kub}</p>
                        <p class="text-xs text-gray-600 mt-1">${kub.alamat}</p>
                        <p class="text-xs text-gray-600">Ketua: ${kub.nama_ketua}</p>
                        <p class="text-xs text-gray-600">Anggota: ${kub.jumlah_anggota} orang</p>
                    </div>`;
            });
        } else {
            cardHTML += `<p class="text-sm text-gray-500 italic bg-gray-50 p-3 rounded-lg text-center">Tidak ada kelompok penerima</p>`;
        }

        cardHTML += `
                    </div>
                    <?php if ($session->get('role') == 'admin') : ?>
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex justify-center items-center gap-3">
                            <a href="<?= base_url('pengadaan/edit/') ?>${row.id_kegiatan}" title="Edit" 
                               class="flex items-center justify-center w-10 h-10 bg-blue-100 hover:bg-blue-200 rounded-lg transition-all duration-200 shadow-sm">
                                <img src="<?= base_url('img/edit (2).png') ?>" alt="Edit" class="h-5 w-5">
                            </a>
                            <a href="<?= base_url('pengadaan/delete/') ?>${row.id_kegiatan}" class="delete-confirm" title="Hapus"
                               class="flex items-center justify-center w-10 h-10 bg-red-100 hover:bg-red-200 rounded-lg transition-all duration-200 shadow-sm">
                                <img src="<?= base_url('img/remove.png') ?>" alt="Hapus" class="h-5 w-5">
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        `;
        mobileCards.innerHTML += cardHTML;
    });
}

function renderTable() {
    const tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = "";

    let dataToShow = filteredData.length ? filteredData : allData;
    let startIndex = (currentPage - 1) * limit;
    let paginatedData = dataToShow.slice(startIndex, startIndex + limit);

    let no = startIndex + 1;
    paginatedData.forEach((row, idx) => {
        const kubArr = row.kub || [];
        const kelompokCount = kubArr.length || 1;
        
        if (kubArr.length > 0) {
            kubArr.forEach((kub, i) => {
                let rowHTML = `<tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors duration-200">`;
                
                if (i === 0) {
                    rowHTML += `
                        <td rowspan="${kelompokCount}" class="px-4 py-4 text-center font-bold text-gray-900">${no}</td>
                        <td rowspan="${kelompokCount}" class="px-4 py-4 text-left font-medium text-gray-900">${row.nama_kegiatan}</td>
                        <td rowspan="${kelompokCount}" class="px-4 py-4 text-left text-gray-700">${row.penyedia}</td>
                        <td rowspan="${kelompokCount}" class="px-4 py-4 text-center font-semibold text-green-600">Rp ${Number(row.pagu_anggaran).toLocaleString()}</td>
                        <td rowspan="${kelompokCount}" class="px-4 py-4 text-center font-semibold text-blue-600">Rp ${Number(row.realisasi_anggaran).toLocaleString()}</td>
                        <td rowspan="${kelompokCount}" class="px-4 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                ${row.tahun}
                            </span>
                        </td>`;
                }
                
                rowHTML += `
                    <td class="px-4 py-4 text-left font-medium text-gray-800">${kub.nama_kub}</td>
                    <td class="px-4 py-4 text-left text-gray-600">${kub.alamat}</td>
                    <td class="px-4 py-4 text-left text-gray-600">${kub.nama_ketua}</td>
                    <td class="px-4 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            ${kub.jumlah_anggota} orang
                        </span>
                    </td>`;

                <?php if ($session->get('role') == 'admin') : ?>
                if (i === 0) {
                    rowHTML += `
                        <td rowspan="${kelompokCount}" class="px-4 py-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="<?= base_url('pengadaan/edit/') ?>${row.id_kegiatan}" class="flex items-center justify-center w-10 h-10 bg-blue-100 hover:bg-blue-200 rounded-lg transition-all duration-200 shadow-sm" title="Edit">
                                    <img src="<?= base_url('img/edit (2).png') ?>" alt="Edit" class="h-5 w-5">
                                </a>
                                <a href="<?= base_url('pengadaan/delete/') ?>${row.id_kegiatan}" class="delete-confirm flex items-center justify-center w-10 h-10 bg-red-100 hover:bg-red-200 rounded-lg transition-all duration-200 shadow-sm" title="Hapus">
                                    <img src="<?= base_url('img/remove.png') ?>" alt="Hapus" class="h-5 w-5">
                                </a>
                            </div>
                        </td>`;
                }
                <?php endif; ?>
                
                rowHTML += `</tr>`;
                tableBody.innerHTML += rowHTML;
            });
        } else {
            let rowHTML = `
                <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors duration-200">
                    <td class="px-4 py-4 text-center font-bold text-gray-900">${no}</td>
                    <td class="px-4 py-4 text-left font-medium text-gray-900">${row.nama_kegiatan}</td>
                    <td class="px-4 py-4 text-left text-gray-700">${row.penyedia}</td>
                    <td class="px-4 py-4 text-center font-semibold text-green-600">Rp ${Number(row.pagu_anggaran).toLocaleString()}</td>
                    <td class="px-4 py-4 text-center font-semibold text-blue-600">Rp ${Number(row.realisasi_anggaran).toLocaleString()}</td>
                    <td class="px-4 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            ${row.tahun}
                        </span>
                    </td>
                    <td colspan="4" class="px-4 py-4 text-center text-gray-500 italic bg-gray-50">Tidak ada kelompok penerima</td>
                    <?php if ($session->get('role') == 'admin') : ?>
                    <td class="px-4 py-4 text-center">
                        <div class="flex justify-center items-center gap-2">
                            <a href="<?= base_url('pengadaan/edit/') ?>${row.id}" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors duration-200" title="Edit">
                                📝
                            </a>
                            <a href="<?= base_url('pengadaan/delete/') ?>${row.id}" class="delete-confirm p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors duration-200" title="Hapus">
                                🗑️
                            </a>
                        </div>
                    </td>
                    <?php endif; ?>
                </tr>
            `;
            tableBody.innerHTML += rowHTML;
        }
        no++;
    });
}

function updatePaginationInfo() {
    let dataToShow = filteredData.length ? filteredData : allData;
    let totalPages = Math.ceil(dataToShow.length / limit);
    let pageText = `Page ${currentPage} of ${totalPages}`;
    
    // Update pagination info
    document.getElementById('pageInfo').innerText = pageText;
    document.getElementById('pageInfoMobile').innerText = pageText;
    
    // Update showing info
    let startIndex = (currentPage - 1) * limit + 1;
    let endIndex = Math.min(startIndex + limit - 1, dataToShow.length);
    document.getElementById('showingInfo').innerText = `${startIndex}-${endIndex}`;
    document.getElementById('totalData').innerText = dataToShow.length;
    
    // Update buttons
    document.getElementById('prevPage').disabled = currentPage <= 1;
    document.getElementById('nextPage').disabled = currentPage >= totalPages;
    document.getElementById('prevPageMobile').disabled = currentPage <= 1;
    document.getElementById('nextPageMobile').disabled = currentPage >= totalPages;
}

function renderData() {
    renderMobileCards();
    renderTable();
    updatePaginationInfo();
}

// Event Listeners
document.getElementById('statsYearFilter').addEventListener('change', updateStatistics);

document.getElementById('prevPage').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        renderData();
    }
});

document.getElementById('nextPage').addEventListener('click', () => {
    let dataToShow = filteredData.length ? filteredData : allData;
    if (currentPage < Math.ceil(dataToShow.length / limit)) {
        currentPage++;
        renderData();
    }
});

document.getElementById('prevPageMobile').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        renderData();
        document.getElementById('mobileCards').scrollIntoView({ behavior: 'smooth' });
    }
});

document.getElementById('nextPageMobile').addEventListener('click', () => {
    let dataToShow = filteredData.length ? filteredData : allData;
    if (currentPage < Math.ceil(dataToShow.length / limit)) {
        currentPage++;
        renderData();
        document.getElementById('mobileCards').scrollIntoView({ behavior: 'smooth' });
    }
});

document.getElementById('itemsPerPage').addEventListener('change', function () {
    limit = parseInt(this.value);
    currentPage = 1;
    renderData();
});

document.getElementById('searchInput').addEventListener('input', applyFilters);
document.getElementById('filterTahun').addEventListener('change', applyFilters);
document.getElementById('filterPenyedia').addEventListener('change', applyFilters);
document.getElementById('resetFilter').addEventListener('click', resetFilter);

function applyFilters() {
    let searchValue = document.getElementById('searchInput').value.toLowerCase();
    let tahunFilter = document.getElementById('filterTahun').value;
    let penyediaFilter = document.getElementById('filterPenyedia').value.toLowerCase();

    filteredData = allData.filter(row => {
        let textMatch =
            row.nama_kegiatan.toLowerCase().includes(searchValue) ||
            row.penyedia.toLowerCase().includes(searchValue);

        let tahunMatch = tahunFilter === '' || row.tahun === tahunFilter;
        let penyediaMatch = penyediaFilter === '' || row.penyedia.toLowerCase().includes(penyediaFilter);

        return textMatch && tahunMatch && penyediaMatch;
    });

    currentPage = 1;
    renderData();
}

function resetFilter() {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterTahun').value = '';
    document.getElementById('filterPenyedia').value = '';
    document.getElementById('statsYearFilter').value = '';
    filteredData = allData;
    currentPage = 1;
    updateStatistics();
    renderData();
}

// Initialize everything
document.addEventListener("DOMContentLoaded", function () {
    initChart();
    fetchData();

    // Delete confirmation
    document.body.addEventListener("click", function (event) {
        if (event.target.closest(".delete-confirm")) {
            event.preventDefault();
            let deleteUrl = event.target.closest(".delete-confirm").href;

            Swal.fire({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        }
    });
});

<?php if (session()->getFlashdata('success')): ?>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '<?= session()->getFlashdata('success') ?>',
    showConfirmButton: false,
    timer: 3000
});
<?php endif; ?>
</script>

<style>
/* Table Improvements */
.table-pengadaan {
    font-size: 13px;
}

.table-pengadaan th {
    background-color: #f8fafc;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.table-pengadaan td {
    vertical-align: middle;
}

/* Mobile Card Enhancements */
.mobile-card {
    font-family: 'Poppins', Arial, sans-serif;
}

/* Responsive Adjustments */
@media (max-width: 767px) {
    #dataTable { display: none !important; }
    #mobileView { display: block !important; }
    
    /* Hide desktop pagination on mobile */
    #prevPage, #nextPage, #pageInfo, #showingInfo, #totalData {
        display: none !important;
    }
}

@media (min-width: 768px) {
    /* Hide mobile pagination on desktop */
    #prevPageMobile, #nextPageMobile, #pageInfoMobile {
        display: none !important;
    }
}

/* Button and form improvements */
button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

button:not(:disabled):hover {
    transform: translateY(-1px);
    transition: all 0.2s ease-in-out;
}

/* Chart container */
#beneficiaryChart {
    max-height: 250px;
}

/* Focus styles for accessibility */
input:focus, select:focus {
    outline: none;
    ring: 2px;
    ring-color: #3B82F6;
    border-color: transparent;
}
</style>
<?= $this->endSection() ?>