<x-admin-layout>
<br><br>
    <table>
    
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">user id</th>
                <th scope="col">username</th>
                <th scope="col">email</th>
                <th scope="col">lastlogin</th>
                <th scope="col">ip addresh</th>
                <th scope="col">page visited</th>
                <th scope="col">Browser</th>
                {{-- <th scope="col">Blacklist</th> --}}
                
                
              </tr>
            </thead>
            <tbody>
    
              @foreach ($trackrecords as $item)
    
              <tr>
                <th scope="row">{{$item['users_id'] }}</th>
                <td>{{$item['name'] }}</td>
                <td>{{$item['email'] }}</td>
                <td>{{$item['created_at'] }}</td>
                <td>{{$item['ip_addresh'] }}</td>
                
                {{-- <td>{{get_browser(null,true)}}</td> --}}
                <td>{{$item['device'] }}</td>
                
                <td><button> 
                  <a href="{{url('active_inactive/'. $item->users_id) }}" >Blacllist </a> 
                </button> </td>
              </tr>
              


              @endforeach
    
            
            </tbody>
          </table>
    
    
    </table>
    


    <h1>pagination pending and modify black list button</h1>
    
    
    </x-admin-layout>