<section class="bg-white border-bottom">
    <div class="container">
        <!-- Filters form -->
        <form
            id="jobFilters"
            class="customWrapper"
            method="GET"
            action=""
            data-autosubmit="true"
        ><!-- set to 'false' to disable auto submit -->
            <!-- Filters: label (icon + text) -->
            <div class="fielterIcon me-2">
                <div>
                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/Filter.png" alt="" class="me-1" />
                    <span>{{ trans('common.filters') }}</span>
                </div>
            </div>

            <!-- ===== Filter #1: Date posted ===== -->
            <div class="custom-select" data-filter-key="date_posted" style="max-width: 145px!important;" data-placeholder="{{ trans('common.most_recent') }}">
                {{--                <label class="custom-select-label">Date</label>--}}
                <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="date24h" value="7"  {{ in_array("7", getSelectedFilters('date_posted')) ? 'checked' : '' }} />
                        <label for="date24h">{{ trans('common.most_recent') }}</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="date15d" value="15"  {{ in_array("15", getSelectedFilters('date_posted')) ? 'checked' : '' }} />
                        <label for="date15d">{{ trans('common.last_15_days') }}</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="date30d" value="30" {{ in_array("30", getSelectedFilters('date_posted')) ? 'checked' : '' }} />
                        <label for="date30d">{{ trans('common.last_30_days') }}</label>
                    </div>
                </div>
                <input type="hidden" class="filter-payload" name="filters[date_posted]" value="[]">
            </div>

            <!-- ===== Filter #2: Job type ===== -->
            <div class="custom-select" data-filter-key="company_type" style="max-width: 115px!important;" data-placeholder="{{ trans('common.job_type') }}">
                {{--                <label class="custom-select-label">Job type</label>--}}
                <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                    @foreach($JobTypes as $JobType)
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" id="ctype-{{ $JobType->slug }}" value="{{ $JobType->slug }}" {{ in_array($JobType->slug, getSelectedFilters('job_type')) ? 'checked' : '' }} />
                            <label for="ctype-{{ $JobType->slug }}">{{ $JobType->name }}</label>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" class="filter-payload" name="filters[job_type]" value="[]">
            </div>

            <!-- ===== Filter #3: Location ===== -->
            <div class="custom-select" data-filter-key="location" style="max-width: 112px!important;" data-placeholder="{{ trans('common.location') }}">
                {{--                <label class="custom-select-label">Location</label>--}}
                <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />

                    <div class="checkbox-item"><input type="checkbox" value="Bagerhat" {{ in_array("Bagerhat", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bagerhat" /> <label for="loc-Bagerhat">Bagerhat</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Bandarban" {{ in_array("Bandarban", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bandarban" /> <label for="loc-Bandarban">Bandarban</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Barguna" {{ in_array("Barguna", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Barguna" /> <label for="loc-Barguna">Barguna</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Barisal" {{ in_array("Barisal", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Barisal" /> <label for="loc-Barisal">Barisal</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Bhola" {{ in_array("Bhola", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bhola" /> <label for="loc-Bhola">Bhola</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Bogura" {{ in_array("Bogura", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bogura" /> <label for="loc-Bogura">Bogura</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Brahmanbaria" {{ in_array("Brahmanbaria", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Brahmanbaria" /> <label for="loc-Brahmanbaria">Brahmanbaria</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Chandpur" {{ in_array("Chandpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chandpur" /> <label for="loc-Chandpur">Chandpur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Chapainawabganj" {{ in_array("Chapainawabganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chapainawabganj" /> <label for="loc-Chapainawabganj">Chapainawabganj</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Chattogram" {{ in_array("Chattogram", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chattogram" /> <label for="loc-Chattogram">Chattogram</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Chuadanga" {{ in_array("Chuadanga", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chuadanga" /> <label for="loc-Chuadanga">Chuadanga</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Coxs Bazar" {{ in_array("Coxs Bazar", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Coxs-Bazar" /> <label for="loc-Coxs-Bazar">Cox's Bazar</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Cumilla" {{ in_array("Cumilla", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Cumilla" /> <label for="loc-Cumilla">Cumilla</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Dhaka" {{ in_array("Dhaka", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Dhaka" /> <label for="loc-Dhaka">Dhaka</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Dinajpur" {{ in_array("Dinajpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Dinajpur" /> <label for="loc-Dinajpur">Dinajpur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Faridpur" {{ in_array("Faridpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Faridpur" /> <label for="loc-Faridpur">Faridpur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Feni" {{ in_array("Feni", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Feni" /> <label for="loc-Feni">Feni</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Gaibandha" {{ in_array("Gaibandha", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Gaibandha" /> <label for="loc-Gaibandha">Gaibandha</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Gazipur" {{ in_array("Gazipur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Gazipur" /> <label for="loc-Gazipur">Gazipur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Gopalganj" {{ in_array("Gopalganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Gopalganj" /> <label for="loc-Gopalganj">Gopalganj</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Habiganj" {{ in_array("Habiganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Habiganj" /> <label for="loc-Habiganj">Habiganj</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Jamalpur" {{ in_array("Jamalpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jamalpur" /> <label for="loc-Jamalpur">Jamalpur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Jashore" {{ in_array("Jashore", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jashore" /> <label for="loc-Jashore">Jashore</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Jhalokati" {{ in_array("Jhalokati", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jhalokati" /> <label for="loc-Jhalokati">Jhalokati</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Jhenaidah" {{ in_array("Jhenaidah", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jhenaidah" /> <label for="loc-Jhenaidah">Jhenaidah</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Joypurhat" {{ in_array("Joypurhat", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Joypurhat" /> <label for="loc-Joypurhat">Joypurhat</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Khagrachari" {{ in_array("Khagrachari", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Khagrachari" /> <label for="loc-Khagrachari">Khagrachari</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Khulna" {{ in_array("Khulna", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Khulna" /> <label for="loc-Khulna">Khulna</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Kishoreganj" {{ in_array("Kishoreganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Kishoreganj" /> <label for="loc-Kishoreganj">Kishoreganj</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Kurigram" {{ in_array("Kurigram", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Kurigram" /> <label for="loc-Kurigram">Kurigram</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Kushtia" {{ in_array("Kushtia", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Kushtia" /> <label for="loc-Kushtia">Kushtia</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Lakshmipur" {{ in_array("Lakshmipur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Lakshmipur" /> <label for="loc-Lakshmipur">Lakshmipur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Lalmonirhat" {{ in_array("Lalmonirhat", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Lalmonirhat" /> <label for="loc-Lalmonirhat">Lalmonirhat</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Madaripur" {{ in_array("Madaripur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Madaripur" /> <label for="loc-Madaripur">Madaripur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Magura" {{ in_array("Magura", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Magura" /> <label for="loc-Magura">Magura</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Manikganj" {{ in_array("Manikganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Manikganj" /> <label for="loc-Manikganj">Manikganj</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Meherpur" {{ in_array("Meherpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Meherpur" /> <label for="loc-Meherpur">Meherpur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Moulvibazar" {{ in_array("Moulvibazar", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Moulvibazar" /> <label for="loc-Moulvibazar">Moulvibazar</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Munshiganj" {{ in_array("Munshiganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Munshiganj" /> <label for="loc-Munshiganj">Munshiganj</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Mymensingh" {{ in_array("Mymensingh", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Mymensingh" /> <label for="loc-Mymensingh">Mymensingh</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Naogaon" {{ in_array("Naogaon", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Naogaon" /> <label for="loc-Naogaon">Naogaon</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Narail" {{ in_array("Narail", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Narail" /> <label for="loc-Narail">Narail</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Narayanganj" {{ in_array("Narayanganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Narayanganj" /> <label for="loc-Narayanganj">Narayanganj</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Narsingdi" {{ in_array("Narsingdi", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Narsingdi" /> <label for="loc-Narsingdi">Narsingdi</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Natore" {{ in_array("Natore", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Natore" /> <label for="loc-Natore">Natore</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Netrokona" {{ in_array("Netrokona", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Netrokona" /> <label for="loc-Netrokona">Netrokona</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Nilphamari" {{ in_array("Nilphamari", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Nilphamari" /> <label for="loc-Nilphamari">Nilphamari</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Noakhali" {{ in_array("Noakhali", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Noakhali" /> <label for="loc-Noakhali">Noakhali</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Pabna" {{ in_array("Pabna", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Pabna" /> <label for="loc-Pabna">Pabna</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Panchagarh" {{ in_array("Panchagarh", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Panchagarh" /> <label for="loc-Panchagarh">Panchagarh</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Patuakhali" {{ in_array("Patuakhali", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Patuakhali" /> <label for="loc-Patuakhali">Patuakhali</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Pirojpur" {{ in_array("Pirojpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Pirojpur" /> <label for="loc-Pirojpur">Pirojpur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Rajbari" {{ in_array("Rajbari", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rajbari" /> <label for="loc-Rajbari">Rajbari</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Rajshahi" {{ in_array("Rajshahi", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rajshahi" /> <label for="loc-Rajshahi">Rajshahi</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Rangamati" {{ in_array("Rangamati", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rangamati" /> <label for="loc-Rangamati">Rangamati</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Rangpur" {{ in_array("Rangpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rangpur" /> <label for="loc-Rangpur">Rangpur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Satkhira" {{ in_array("Satkhira", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Satkhira" /> <label for="loc-Satkhira">Satkhira</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Shariatpur" {{ in_array("Shariatpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Shariatpur" /> <label for="loc-Shariatpur">Shariatpur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Sherpur" {{ in_array("Sherpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sherpur" /> <label for="loc-Sherpur">Sherpur</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Sirajganj" {{ in_array("Sirajganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sirajganj" /> <label for="loc-Sirajganj">Sirajganj</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Sunamganj" {{ in_array("Sunamganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sunamganj" /> <label for="loc-Sunamganj">Sunamganj</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Sylhet" {{ in_array("Sylhet", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sylhet" /> <label for="loc-Sylhet">Sylhet</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Tangail" {{ in_array("Tangail", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Tangail" /> <label for="loc-Tangail">Tangail</label></div>
                    <div class="checkbox-item"><input type="checkbox" value="Thakurgaon" {{ in_array("Thakurgaon", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Thakurgaon" /> <label for="loc-Thakurgaon">Thakurgaon</label></div>

                </div>
                <input type="hidden" class="filter-payload" name="filters[district]" value="[]">
            </div>

            <!-- ===== Filter #4: Industry ===== -->
            <div class="custom-select" data-filter-key="industry" style="max-width: 110px!important;" data-placeholder="{{ trans('common.industry') }}">
                {{--                <label class="custom-select-label">Industry</label>--}}
                <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                    @foreach($industries as $industry)
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" id="ind-{{ $industry->slug }}" {{ in_array($industry->slug, getSelectedFilters('industry')) ? 'checked' : '' }} value="{{ $industry->slug }}" />
                            <label for="ind-{{ $industry->slug }}">{{ $industry->name }}</label>
                        </div>

                    @endforeach
                </div>
                <input type="hidden" class="filter-payload" name="filters[industry]" value="[]">
            </div>

            <!-- ===== Filter #6: Job Workplace type ===== -->
            <div class="custom-select" data-filter-key="salary" style="max-width: 132px!important;" data-placeholder="{{ trans('common.job_nature') }}">
                {{--                <label class="custom-select-label">Job Nature</label>--}}
                <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                    @foreach($jobLocationTypes as $jobLocationType)
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" {{ in_array($jobLocationType->slug, getSelectedFilters('job_location_type')) ? 'checked' : '' }} id="jlt-{{ $jobLocationType->slug }}" value="{{ $jobLocationType->slug }}" />
                            <label for="jlt-{{ $jobLocationType->slug }}">{{ $jobLocationType->name }}</label>
                        </div>

                    @endforeach
                </div>
                <input type="hidden" class="filter-payload" name="filters[job_location_type]" value="[]">
            </div>

            <!-- Clear All button (resets the filter selections) -->
            <div>
                <button type="submit" class="clear-all-btn btn btn-sm border px-2 " style="border: 1px solid lightgrey!important;" id="clearAllBtn">{{ trans('common.search') }}</button>
                <button type="button" class="clear-all-btn btn btn-sm border px-2" style="border: 1px solid lightgrey!important;" id="clearAllBtn">{{ trans('common.clear_all') }}</button>
            </div>

        </form>
    </div>
</section>
