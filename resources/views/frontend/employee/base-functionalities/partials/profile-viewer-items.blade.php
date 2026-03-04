@foreach($profileViewerIds as $myProfileViewer)
    <div class="pv-viewer-card" style="animation-delay: {{ $loop->index * 0.04 }}s">
        <a href="{{ route('view-company-profile', $myProfileViewer?->employer?->employerCompanyInfo?->id ?? 3) }}" class="pv-viewer-link">
            <div class="pv-viewer-avatar">
                <img src="{{ asset($myProfileViewer?->employer?->employerCompanyInfo?->logo ?? '/frontend/company-vector.jpg') }}" alt="{{ $myProfileViewer?->employer?->employerCompanyInfo?->name ?? 'Company' }}" />
            </div>
            <div class="pv-viewer-info">
                <span class="pv-viewer-name">{{ $myProfileViewer?->employer?->employerCompanyInfo?->name ?? 'Company Name' }}</span>
                <span class="pv-viewer-time">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Viewed {{ optional($myProfileViewer->created_at)->diffForHumans() }}
                </span>
            </div>
        </a>
        <div class="pv-viewer-action">
            <a href="{{ route('view-company-profile', $myProfileViewer?->employer?->employerCompanyInfo?->id ?? 3) }}" class="pv-visit-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                <span>Visit</span>
            </a>
        </div>
    </div>
@endforeach
