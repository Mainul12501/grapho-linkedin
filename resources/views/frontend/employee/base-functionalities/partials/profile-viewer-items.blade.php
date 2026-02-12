@foreach($profileViewerIds as $myProfileViewer)
    <div class="profileViewer-row">
        <div class="company">
            <img src="{{ asset($myProfileViewer?->employer?->employerCompanyInfo?->logo ?? '/frontend/company-vector.jpg') }}"
                 style="max-width:58px">

            <div class="company-info">
                <a href="{{ route('view-company-profile', $myProfileViewer?->employer?->employerCompanyInfo?->id) }}" style="text-decoration: none">
                    <span>{{ $myProfileViewer?->employer?->employerCompanyInfo?->name ?? 'Company Name' }}</span>
                </a>
            </div>
        </div>

        <div class="time">
            Viewed {{ optional($myProfileViewer->created_at)->diffForHumans() }}
        </div>
    </div>
@endforeach
