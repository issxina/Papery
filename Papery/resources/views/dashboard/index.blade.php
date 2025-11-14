@extends('home')

@section('css_before')

<style>
    /* Dashboard Custom Styles */
    .page-title {
        display: inline-block;
        background: #574f44;
        color: #fff;
        padding: 10px 25px;
        border-radius: 30px;
        font-size: 1.6rem;
        font-weight: 600;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.25);
    }

    /* Stat Cards */
    .stat-card {
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .stat-card h2 {
        color: #498259;
        font-weight: 700;
    }

    .stat-card h6 {
        color: #574f44;
        font-weight: 600;
    }

    /* Table headers */
    .table thead {
        background-color: #8dba98;
        color: #fff;
    }

    .table tbody tr:hover {
        background-color: #f7f4ed;
    }

    /* Card headers */
    .card-header {
        background: #574f44;
        color: #fff;
        font-weight: 600;
    }

    /* Chart container */
    .chart-container {
        position: relative;
        height: 350px;
        width: 100%;
    }

    /* อันดับหนังสือ */
    .rank-badge {
        display: inline-block;
        background: #498259;
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        text-align: center;
        line-height: 32px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .list-group-item {
        transition: background-color 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f7f4ed;
    }

    /* Header ตาราง */
    .table-header {
        background-color: #8dba98;
        color: #fff;
    }

    /* แถว */
    .order-row:hover {
        background-color: #f7f4ed;
        transition: background 0.3s;
    }


    /* Badge สถานะ */
    .order-badge {
        background-color: #574f44;
        color: #fff;
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 12px;
        font-weight: 500;
    }
</style>

@endsection

@section('content')

<div class="container mt-4">
    <h3 class="mb-4 page-title">Dashboard</h3>

    <!-- Stat Cards -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card stat-card text-center p-3">
                <h6>Orders</h6>
                <h2>{{ $orderCount }}</h2>
                <a href="/order" class="stretched-link"></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-3">
                <h6>Users</h6>
                <h2>{{ $userCount }}</h2>
                <a href="/user" class="stretched-link"></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-3">
                <h6>Books</h6>
                <h2>{{ $bookCount }}</h2>
                <a href=/book class="stretched-link"></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-3">
                <h6>Category</h6>
                <h2>{{ $categoryCount }}</h2>
                <a href="/category" class="stretched-link"></a>
            </div>
        </div>
    </div>

    <!-- Sales Charts Row -->
    <div class="row mt-4">
        <!-- Line Chart -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h5 class="mb-0">Sales Overview <small class="text-light fw-normal">(รายเดือน)</small></h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="mb-0">Books by Category</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Orders -->
    <div class="card mt-4 shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">Recent Orders</h5>
        </div>
        <div class="card-body p-0">
            <table class="table align-middle mb-0">
                <thead class="table-header">
                    <tr>
                        <th>Order No.</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr class="order-row">
                        <td class="fw-bold text-dark">#{{ $order->id }}</td>
                        <td class="text-dark">
                            {{ $order->user_name }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                        <td class="fw-semibold text-success">฿{{ number_format($order->order_amount, 2) }}</td>
                        <td>
                            @php
                            $status = strtolower($order->order_status ?? 'pending');
                            $badgeClass = match($status) {
                                'pending' => 'bg-secondary',
                                'paid' => 'bg-info',
                                'packed' => 'bg-primary',
                                'shipped' => 'bg-warning text-dark',
                                'completed' => 'bg-success',
                                'cancelled' => 'bg-danger',
                            default => 'bg-secondary',
                            };
                            @endphp
                            <span class="badge px-3 py-2 {{ $badgeClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Top Selling -->
    <div class="card mt-4 shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">Top Selling Books</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @forelse($bestSellingBooks as $index => $book)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="rank-badge me-3">{{ $index + 1 }}</span>
                        <div class="fw-bold text-dark">{{ $book->book_title }}</div>
                    </div>
                    <div class="d-flex align-items-end">ขายแล้ว {{ $book->total_sold }} เล่ม</div>
                </li>
                @empty
                <li class="list-group-item text-center text-muted">
                    ยังไม่มีข้อมูลการขาย
                </li>
                @endforelse
            </ul>
        </div>
    </div>

</div>
@endsection

@section('js_before')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Line Chart
    const ctxLine = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: @json($salesLabels),
            datasets: [{
                label: 'ยอดขาย (บาท)',
                data: @json($salesData),
                borderColor: '#498259',
                backgroundColor: 'rgba(73, 130, 89, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#574f44',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#574f44',
                        font: {
                            weight: '600'
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => `฿${ctx.formattedValue}`
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#574f44'
                    },
                    grid: {
                        color: 'rgba(87,79,68,0.1)'
                    }
                },
                y: {
                    ticks: {
                        color: '#574f44'
                    },
                    grid: {
                        color: 'rgba(87,79,68,0.1)'
                    }
                }
            }
        }
    });

    // Pie Chart
    const ctxCategory = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(ctxCategory, {
        type: 'pie',
        data: {
            labels: @json($categoryLabels),
            datasets: [{
                data: @json($categoryData),
                backgroundColor: [
                    '#498259', '#8dba98', '#574f44', '#f7f4ed', '#a67c52'
                ],
                borderColor: '#fff',
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: '#574f44',
                        font: {
                            weight: '600'
                        },
                        boxWidth: 20,
                        padding: 10
                    }
                }
            }
        }
    });
</script>

@endsection