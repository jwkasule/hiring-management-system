<x-admin-layout>

    <div>
    
        
        @if(session()->has('error'))
            <span class="alert alert-danger">
                <strong>{{ session()->get('error') }}</strong>
            </span>
        @endif

        @if(session()->has('success'))
            <span class="alert alert-success">
                <strong>{{ session()->get('success') }}</strong>
            </span>
        @endif

        <div>
            <form method="POST" action="/change_password">
                @csrf
                <div>
                    <label for="password">Current Password</label>
                    <div class="col-md-6">
                        <input type="password"  @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password">
                        @error('current_password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="password">New Password</label>
                    <div class="col-md-6">
                        <input type="password"  @error('password') is-invalid @enderror" name="password" autocomplete="password">
                        @error('password')
                          <span role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div >
                    <label for="password" >Password Confirmation</label>
                    <div class="col-md-6">
                        <input type="password" @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="password_confirmation">
                        @error('password_confirmation')
                          <span  role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                
                    <div>
                        <br>
                        <button type="submit">
                            Change Password
                        </button>
                    </div>
                
            </form>
        </div>
    </div>

</x-admin-layout>