pipeline {
  agent any
  stages {
    stage('Start docker') {
      steps {
        sh 'sudo docker-compose up -d'
      }
    }
    stage('PHPUnit') {
      steps {
        sh 'sudo ./scripts/test.sh'
      }
    }
  }
}
