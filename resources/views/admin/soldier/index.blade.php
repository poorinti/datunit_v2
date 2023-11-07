<x-app-layout>
    <x-slot name="header">
        <h2 class="hidden text-xl font-semibold leading-tight text-gray-800 sm:block ">
            ข้อมูลกำลังพล
            <b class="float-end">จำนวนกำลังพลทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_soldier,0)}}</button>  นาย</b>
        </h2>
        <h2 class="text-xl font-semibold leading-tight text-gray-800 sm:block md:hidden lg:hidden xl:hidden">
         <b class="">จำนวนกำลังพลทั้งหมด <button class="btn btn-primary" style="font-weight: 800;">{{ number_format( $total_soldier,0)}}</button>  นาย</b>
        </h2>

</x-slot>


            {{-- @foreach ( $Department as $key=>$row )


            <div class="col-auto my-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">Special {{$row->total}}</h5>
                      <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                      <a href="#" class="btn btn-primary">{{$row->department_name}} </a>
                    </div>
                  </div>
            </div>

        @endforeach --}}

    <div class="py-12">
        <div class="mx-auto max-w-auto sm:px-6 lg:px-8">

            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <form action="/soldier/all"  name="frmsearch" id="frmsearch" method="post">
                    @csrf

                <div class="my-3 row">
                    <div class="my-2 form-group">

                    </div>

                    <div class="input-group">


                        <select class="form-control" name="soldier_dep_id" id="soldier_dep_id" >
                            <option value="">แสดงทั้งหมด</option>
                                @foreach ( $Department as $key=>$row )

                                <option value="{{$row->dep_id}}" {{ $soldier_dep_id==$row->dep_id ? 'selected' :'' }}>{{$row->department_name}} ({{$row->total}})</option>
                            @endforeach
                       </select>

                       <select class="form-control" name="soldier_provinces" id="soldier_provinces" >
                        <option value="">เลือกจังหวัด</option>
                            @foreach ( $provinces as $key=>$item )
                            <option value="{{ $item->province }}" {{ $item->province==$soldier_provinces ? 'selected' : ''}}>{{ $item->province }}</option>

                            @endforeach
                        </select>

                         {{-- {{dd($search);}} --}}
                        <input type="text" class="form-control" placeholder="ค้นหากำลังพล" id="search" name="search" value="{{isset($search) ? $search :"" }}">
                        <button class="mr-2 text-white btn btn-primary bg-primary" type="sumit">ค้นหา</button>
                        <a href="{{url('/soldier/startadd')}}" class="hidden mr-2 text-white bg-purple-700 btn btn-primary sm:block "> เพิ่มกำลังพล</a>
                        <a href="{{url('/soldier/excel')}}" class="hidden mr-2 text-white btn btn-success sm:block">import excel</a>
                    </div>
                </div>
                </form>
                <div class="row">
                    @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif

                    <div class="col-md-12">
                        <div class="">

                            <table class="table table-striped">
                                <thead class="table-warning">
                                  <tr class="text-center">
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ภาพประกอบ</th>
                                    <th scope="col">ชื่อ-สกุล</th>
                                    <th scope="col" class="hidden sm:table-cell">เลขบัตรประชาชน</th>
                                    <th style="width: 80px;" scope="col">ผลัด/ปี</th>
                                    <th scope="col">หน่วย</th>
                                    <th scope="col">จังหวัด</th>
                                    <th scope="col" class="hidden sm:table-cell">แก้ไข</th>
                                    <th scope="col" class="hidden sm:table-cell">ลบ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $soldier as $row )
                                  <tr class="text-center ">
                                    <th class="text-center"> {{$soldier->firstItem()+$loop->index}}</th>
                                    <td >
                                        <a href="{{url('/soldier/edit/'.$row->soldier_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($soldier_dep_id) ? '&soldier_dep_id='.$soldier_dep_id : '' }}" >

                                        {{-- isset จากฐานข้อมูล ถ้าไม่มีภาพ ให้ดึงเอา โลโก้มา --}}
                                        <img src="{{isset($row->soldier_image) ? asset($row->soldier_image) : '/image/logo/logo1.png'}}" alt="{{ isset($row->soldier_image) ? asset($row->soldier_image) : '' }}" width="100px" height="100px" class="mx-auto" >
                                        </a>
                                    </td>


                                    <td class="text-left " >{{$row->soldier_name}}</td>
                                    <td  class="hidden sm:table-cell">{{$row->soldier_id }}</td>
                                    <td>{{$row->soldier_intern}}</td>
                                    <td>{{$row->soldiers_dep_name}}</td>
                                    <td>{{$row->soldier_province}}</td>
                                    <td class="hidden sm:table-cell"><a href="{{url('/soldier/edit/'.$row->soldier_id)}}{{ "?page=".Request::get('page') }}{{isset($search) ? '&search='.$search : '' }}{{isset($soldier_dep_id) ? '&soldier_dep_id='.$soldier_dep_id : '' }}{{isset($soldier_provinces) ? '&soldier_provinces='.$soldier_provinces : '' }}" class="btn btn-danger"> แก้ไข</a></td>
                                    <td class="hidden sm:table-cell"><a href="{{url('/soldier/delete/'.$row->soldier_id)}}" class="btn btn-warning" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"> ลบ</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>

                            <br>

                            {{$soldier->appends(['search' => isset($search) ? $search : '','soldier_dep_id'=>isset($soldier_dep_id) ?$soldier_dep_id :'' ,"soldier_provinces"=> isset($soldier_provinces) ? $soldier_provinces : ''])->links()}}


                        </div>
                    </div>

                     {{-- <div class="col-md-4 ">
                        <div class="card">
                            <div class="card-header">แบบฟอร์มข้อมูลกำลังพล</div>
                            <div class="card-body">
                                <form action="{{route('addService')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label for="service_name">ขื่อกำลังพล</label>
                                    <input type="text" class="form-control" name="service_name">
                                    @error('service_name')<!-- ชื่อแท็ก name-->
                                      <div class="my-2">
                                        <span class="text-red-600 text">{{$message}}</span>
                                      </div>
                                    @enderror
                                    <br>

                                    <label for="service_image">ภาพประกรอบ</label>
                                    <input type="file" class="form-control" name="service_image">
                                    @error('service_image')
                                      <div class="my-2">
                                        <span class="text-red-600 text">{{$message}}</span>
                                      </div>
                                    @enderror
                                    <br>
                                    <a href="{{url('/service/startup')}}" class="btn btn-danger"> เพิ่มกำลังพล</a>

                                    <input type="submit" value="บันทัก" class="text-black btn btn-primary">
                                </form>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

