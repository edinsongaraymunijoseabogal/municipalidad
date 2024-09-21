<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">{{ __('Admin Dashboard') }}</h1>

        <!-- Fila de estadísticas clave -->
        <div class="row mb-4">
            <!-- Total de Noticias -->
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-newspaper"></i> {{ __('Total News') }}</h5>
                        <p class="card-text display-4">{{ $totalNoticias }}</p>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a href="{{ route('admin.posts.index') }}" class="text-white">{{ __('View All') }}</a>
                        <i class="fas fa-arrow-right text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Total de Videos -->
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-video"></i> {{ __('Total Videos') }}</h5>
                        <p class="card-text display-4">{{ $totalVideos }}</p>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a href="{{ route('admin.videos.index') }}" class="text-white">{{ __('View All') }}</a>
                        <i class="fas fa-arrow-right text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Total de Usuarios -->
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-users"></i> {{ __('Total Users') }}</h5>
                        <p class="card-text display-4">{{ $totalUsuarios }}</p>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="text-white">{{ __('View All') }}</a>
                        <i class="fas fa-arrow-right text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Total de Documentos -->
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-file-alt"></i> {{ __('Total Documents') }}</h5>
                        <p class="card-text display-4">{{ $totalDocumentos }}</p>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a href="{{ route('admin.documents.index') }}" class="text-white">{{ __('View All') }}</a>
                        <i class="fas fa-arrow-right text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fila de gráficas -->
        <div class="row mb-4">
            <!-- Gráfica de visitas a videos -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-chart-bar"></i> {{ __('Video Views Over Time') }}</h5>
                        <canvas id="videoViewsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfica de visitas a noticias -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-chart-bar"></i> {{ __('News Views Over Time') }}</h5>
                        <canvas id="newsViewsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
