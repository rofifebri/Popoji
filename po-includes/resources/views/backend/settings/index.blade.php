@extends('layouts.app')
@section('title', 'Settings')

@section('content')
	<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-20">
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/dashboard/themes/table') }}">Appearance</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/dashboard/settings/table') }}">Settings</a></li>
					<li class="breadcrumb-item active" aria-current="page">List Settings</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">List Settings</h4>
		</div>
		
		<div><a href="{{ url('dashboard/settings/table') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-t-10"><i data-feather="grid" class="wd-10 mg-r-5"></i> Table</a></div>
	</div>
	
	<ul class="nav nav-tabs nav-justified" id="settingTab" role="tablist">
		@foreach($groups as $group)
			<li class="nav-item">
				<a class="nav-link {{ $group->groups == 'General' ? 'active' : '' }}" id="{{ strtolower($group->groups) }}-tab" data-toggle="tab" href="#{{ strtolower($group->groups) }}" role="tab" aria-controls="{{ strtolower($group->groups) }}" aria-selected="true">{{ $group->groups }}</a>
			</li>
		@endforeach
	</ul>
	<div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="settingTabContent">
		@foreach($groups as $group)
			<div class="tab-pane {{ $group->groups == 'General' ? 'active' : '' }}" id="{{ strtolower($group->groups) }}" role="tabpanel" aria-labelledby="{{ strtolower($group->groups) }}-tab">
				<div class="table-responsive">
					<table class="table table-striped mg-b-0">
						<tbody>
							@foreach(getSettingGroup($group->groups) as $option)
								<tr>
									<th width="200">{{ $option->options }}</th>
									<td>{{ $option->value }}</td>
									<td width="30"><a href="{{ url('dashboard/settings/'.Hashids::encode($option->id).'/edit') }}" class="btn btn-primary btn-xs btn-icon" title="Edit" data-toggle="tooltip" data-placement="left"><i class="fa fa-edit"></i></a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		@endforeach
	</div>
@endsection