# config valid only for Capistrano 3.1
lock '3.1.0'

set :application, 'martynas.snekuciai.com'
set :repo_url, 'git@github.com:Hamlis/martynas.snekuciai.com.git'

# Default branch is :master
# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

# Default deploy_to directory is /var/www/my_app
set :deploy_to, '/var/www/martynas.snekuciai.com'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :pretty
# set :format, :pretty

# Default value for :log_level is :debug
# set :log_level, :debug

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# set :linked_files, %w{config/database.yml}

# Default value for linked_dirs is []
# set :linked_dirs, %w{bin log tmp/pids tmp/cache tmp/sockets vendor/bundle public/system}

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
# set :keep_releases, 5

SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"

namespace :deploy do

  after :starting, 'composer:install_executable'

  desc 'Restart application'
  task :restart do
    on roles(:app), in: :sequence, wait: 1 do
      # restart mechanism here:
      execute :sudo, 'service', 'php5-fpm', 'restart'
    end
  end

  after :publishing, :restart

end
