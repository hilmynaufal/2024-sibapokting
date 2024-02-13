<div>
                   <!--begin::Details-->
                   <div class="d-flex flex-wrap py-5">
                       <!--begin::Row-->
                       <div class="flex-equal me-5 table-responsive">
                           <!--begin::Details-->
                           <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2 m-0">
                               <!--begin::Row-->
                               <tbody><tr>
                                   <td class="text-gray-500 min-w-175px w-175px">NOP</td>
                                   <td class="text-gray-800 min-w-200px">
                                       <span class="text-gray-800 text-hover-primary">
                                           {{ $objek_pajak->nop }}
                                       </span>
                                   </td>
                               </tr>
                               <!--end::Row-->

                               <!--begin::Row-->
                               <tr>
                                   <td class="text-gray-500">Nama Lengkap</td>
                                   <td class="text-gray-800">
                                       {{ $objek_pajak->nama_sppt }}
                                   </td>
                               </tr>
                               <!--end::Row-->

                               <!--begin::Row-->
                               <tr>
                                   <td class="text-gray-500">Alamat:</td>
                                   <td class="text-gray-800">
                                       {{ $objek_pajak->alamat }} RT. {{ $objek_pajak->rt }} / RW.  {{ $objek_pajak->rw }}
                                   </td>
                               </tr>
                               <!--end::Row-->
                           </tbody></table>
                           <!--end::Details-->
                       </div>
                       <!--end::Row-->

                       <!--begin::Row-->
                       <div class="flex-equal table-responsive">
                           <!--begin::Details-->
                           <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2 m-0">
                               <!--begin::Row-->
                               <tbody><tr>
                                   <td class="text-gray-500 min-w-175px w-175px">Desa</td>
                                   <td class="text-gray-800 min-w-200px">
                                       <a href="#" class="text-gray-800 text-hover-primary">
                                           {{ $objek_pajak->kelurahan }}
                                       </a>
                                   </td>
                               </tr>
                               <!--end::Row-->

                               <!--begin::Row-->
                               <tr>
                                   <td class="text-gray-500">Kecamatan</td>
                                   <td class="text-gray-800">
                                       {{ $objek_pajak->kecamatan }}
                                   </td>
                               </tr>
                               <!--end::Row-->

                               <!--begin::Row-->
                               <tr>
                                   <td class="text-gray-500">Kabupaten</td>
                                   <td class="text-gray-800">
                                       {{ $objek_pajak->kabupaten_kota }}
                                   </td>
                               </tr>
                               <!--end::Row-->

                               <!--begin::Row-->
                               <tr>
                                   <td class="text-gray-500">Provinsi</td>
                                   <td class="text-gray-800">
                                       Jawa Barat
                                   </td>
                               </tr>
                               <!--end::Row-->
                           </tbody></table>
                           <!--end::Details-->
                       </div>
                       <!--end::Row-->
                   </div>
                   <!--end::Row-->
             


</div>