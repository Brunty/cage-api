pipeline {
  agent any
  stages {
    stage('Start docker') {
      steps {
        sh 'sudo docker-compose up -d'
      }
    }
    stage('Composer Install') {
      steps {
        sh 'sudo docker-compose exec -T php pwd && ls -lah && ls -lah /usr/bin/ && /usr/bin/composer install'
      }
    }
    stage('PHPUnit') {
      steps {
        sh 'sudo ./scripts/test.sh'
      }
    }
  }
  post {
    always {
      sh 'sudo docker-compose down'
    }
  }
}
